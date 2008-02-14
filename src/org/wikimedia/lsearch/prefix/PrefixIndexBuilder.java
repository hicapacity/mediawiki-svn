package org.wikimedia.lsearch.prefix;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Collections;
import java.util.Comparator;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Iterator;
import java.util.Map.Entry;

import org.apache.log4j.Logger;
import org.apache.lucene.analysis.SimpleAnalyzer;
import org.apache.lucene.analysis.Token;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.index.IndexReader;
import org.apache.lucene.index.IndexWriter;
import org.apache.lucene.index.Term;
import org.apache.lucene.index.TermDocs;
import org.wikimedia.lsearch.analyzers.FastWikiTokenizerEngine;
import org.wikimedia.lsearch.analyzers.FilterFactory;
import org.wikimedia.lsearch.analyzers.LowercaseAnalyzer;
import org.wikimedia.lsearch.analyzers.PrefixAnalyzer;
import org.wikimedia.lsearch.analyzers.TokenizerOptions;
import org.wikimedia.lsearch.config.Configuration;
import org.wikimedia.lsearch.config.IndexId;
import org.wikimedia.lsearch.index.IndexThread;
import org.wikimedia.lsearch.ranks.Links;
import org.wikimedia.lsearch.ranks.StringList;
import org.wikimedia.lsearch.spell.api.LuceneDictionary;
import org.wikimedia.lsearch.spell.api.Dictionary.Word;

/**
 * Build an index of all title prefixes
 * 
 * @author rainman
 *
 */
public class PrefixIndexBuilder {
	static Logger log = Logger.getLogger(PrefixIndexBuilder.class);
	
	public static void main(String[] args) throws IOException{
		int perPrefix = 15;
		boolean usetemp = false;
		String dbname = null;
		
		Configuration.open();		
		if(args.length == 0){
			System.out.println("Syntax: java PrefixIndexBuilder [-t] [-p <num>] <dbname>");
			System.out.println("Options:");
			System.out.println("   -t       - reuse temporary index");
			System.out.println("   -p <num> - titles per prefix (default: "+perPrefix+")");
			return;
		}
		for(int i=0;i<args.length;i++){
			if(args[i].equals("-t"))
				usetemp = true;
			else if(args[i].equals("-p"))
				perPrefix = Integer.parseInt(args[++i]);
			else if(args[i].startsWith("-")){
				System.out.println("Unrecognized option "+args[i]);
				return;
			} else
				dbname = args[i];
		}		
		
		IndexId iid = IndexId.get(dbname);
		IndexId pre = iid.getPrefix();
		FilterFactory filters = new FilterFactory(iid);
		
		long start = System.currentTimeMillis();
		
		if(!usetemp){
			IndexWriter writer = new IndexWriter(pre.getTempPath(),new PrefixAnalyzer(),true);
			writer.setMergeFactor(20);
			writer.setMaxBufferedDocs(500);
			// FIXME: shouldn't be using import path
			Links links = Links.openForRead(iid,iid.getLinks().getImportPath());
			log.info("Writing temp index");
			int count = 0;
			LuceneDictionary dict = links.getKeys();
			dict.setNoProgressReport();
			Word w;
			// lowercase redirect keys 
			HashSet<String> addedRedirects = new HashSet<String>();
			// iterate over all documents in the index
			key_loop: while((w = dict.next()) != null){
				String key = w.getWord();
				if(++count % 1000 == 0)
					System.out.println("Processed "+count);
				int ref = links.getNumInLinks(key);
				String redirect = links.getRedirectTarget(key);				
				if(redirect == null)
					redirect = "";
				else if(redirect.equalsIgnoreCase(key))
					continue; // ignore camelcase redirects (case Aa -> AA)
				else if(addedRedirects.contains(key.toLowerCase()))
					continue;
				else{
					// check case Aa -> B, AA -> B
					ArrayList<String> allRedirects = links.getRedirectsTo(redirect);
					for(String r : allRedirects){
						if(!r.equals(key) && r.equalsIgnoreCase(key)){
							// discard if there is a camel-case redirect with more inlinks
							if(links.getNumInLinks(r) > ref)
								continue key_loop;
						}
					}
				}
				// add to index
				Document d = new Document();
				d.add(new Field("key",key,Field.Store.YES,Field.Index.NO));
				ArrayList<Token> canonized = canonize(key,iid,filters); 
				for(Token t : canonized){
					d.add(new Field("key",t.termText(),Field.Store.NO,Field.Index.TOKENIZED));
				}
				d.add(new Field("redirect",redirect,Field.Store.YES,Field.Index.NO));
				d.add(new Field("ref",Integer.toString(ref),Field.Store.YES,Field.Index.NO));			
				writer.addDocument(d);				
				if(redirect != null)
					addedRedirects.add(key);				
			}
			log.info("Optimizing temp index");
			writer.optimize();
			writer.close();
		}
		log.info("Writing prefix index");
		IndexWriter writer = new IndexWriter(pre.getImportPath(), new LowercaseAnalyzer(),true);
		writer.setMergeFactor(20);
		writer.setMaxBufferedDocs(1000);
		IndexReader ir = IndexReader.open(pre.getTempPath());
		LuceneDictionary dict = new LuceneDictionary(ir,"key");
		Word w;
		while((w = dict.next()) != null){
			String prefix = w.getWord();
			Term t = new Term("key",prefix);
			// filter out unique keys
			if(ir.docFreq(t) < 2)
				continue;
			TermDocs td = ir.termDocs(t);
			// key -> rank
			HashMap<String,Double> refs = new HashMap<String,Double>();
			while(td.next()){
				Document d = ir.document(td.doc());
				String key = d.get("key");
				double ref = Integer.parseInt(d.get("ref")) * lengthCoeff(key,prefix);
				if(key.equalsIgnoreCase(prefix))
					ref = Double.MAX_VALUE; // always put exact match first
				refs.put(key,ref);
			}
			ArrayList<Entry<String,Double>> sorted = new ArrayList<Entry<String,Double>>();
			sorted.addAll(refs.entrySet());
			Collections.sort(sorted,new Comparator<Entry<String,Double>>() {
				public int compare(Entry<String,Double> o1, Entry<String,Double> o2){
					double d = o2.getValue() - o1.getValue();
					if(d == 0) return 0;
					if(d > 0) return 1;
					else return -1;
				}
			});
			ArrayList<String> selected = new ArrayList<String>();
			for(int i=0;i<perPrefix && i<sorted.size();i++){
				String key = sorted.get(i).getKey();
				selected.add(key);
			}
			Document d = new Document();
			d.add(new Field("prefix",prefix,Field.Store.NO,Field.Index.NO_NORMS));
			d.add(new Field("articles",new StringList(selected).toString(),Field.Store.YES,Field.Index.NO));
			writer.addDocument(d);
		}
		log.info("Adding title keys ...");
		int count = 0;
		for(int i=0;i<ir.maxDoc();i++){
			if(++count % 1000 == 0)
				System.out.println("Added "+count);
			if(ir.isDeleted(i))
				continue;
			Document d = new Document();
			String key = ir.document(i).get("key");
			d.add(new Field("key",key,Field.Store.YES,Field.Index.NO));
			ArrayList<Token> canonized = canonize(key,iid,filters); 
			for(Token t : canonized){
				d.add(new Field("key",t.termText(),Field.Store.NO,Field.Index.TOKENIZED));
			}
			writer.addDocument(d);
		}
		ir.close();
		log.info("Optimizing ...");
		writer.optimize();
		writer.close();		
		
		IndexThread.makeIndexSnapshot(pre,pre.getImportPath());
		long delta = System.currentTimeMillis() - start;
		System.out.println("Finished in "+formatTime(delta));
	}
	
	private static ArrayList<Token> canonize(String key, IndexId iid, FilterFactory filters) throws IOException{
		FastWikiTokenizerEngine tokenizer = new FastWikiTokenizerEngine(key,iid,new TokenizerOptions.PrefixCanonization());
		return filters.canonize(tokenizer.parse());		
	}
	
	private static double lengthCoeff(String key, String prefix) {
		if(prefix.length() >= key.length())
			return 1;
		else
			return square(((double)prefix.length())/((double)key.length()));
	}
	
	final private static double square(double x){
		return x*x;
	}

	private static String formatTime(long l) {
		l /= 1000;
		if(l >= 3600) return l/3600+"h "+(l%3600)/60+"m "+(l%60)+"s";
		else if(l >= 60) return (l%3600)/60+"m "+(l%60)+"s";
		else return l+"s";
	}

}
