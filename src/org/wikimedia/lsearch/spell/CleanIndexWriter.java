package org.wikimedia.lsearch.spell;

import java.io.IOException;
import java.util.Collection;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map.Entry;

import org.apache.log4j.Logger;
import org.apache.lucene.analysis.Analyzer;
import org.apache.lucene.document.Document;
import org.apache.lucene.document.Field;
import org.apache.lucene.index.IndexWriter;
import org.wikimedia.lsearch.analyzers.FieldBuilder;
import org.wikimedia.lsearch.analyzers.FilterFactory;
import org.wikimedia.lsearch.beans.Article;
import org.wikimedia.lsearch.beans.IndexReportCard;
import org.wikimedia.lsearch.config.GlobalConfiguration;
import org.wikimedia.lsearch.config.IndexId;
import org.wikimedia.lsearch.index.IndexUpdateRecord;
import org.wikimedia.lsearch.index.WikiIndexModifier;
import org.wikimedia.lsearch.index.WikiSimilarity;
import org.wikimedia.lsearch.util.HighFreqTerms;

/**
 * IndexWriter for making temporary "clean" indexes which
 * are to be used to rebuild the word-suggest indexes
 * 
 * @author rainman
 *
 */
public class CleanIndexWriter {
	static Logger log = Logger.getLogger(CleanIndexWriter.class);
	protected IndexId iid;
	protected IndexWriter writerMain;
	protected IndexWriter writerAll;
	protected FieldBuilder builder;
	protected String langCode;
	
	public static final String[] ENGLISH_STOP_WORDS = {
	    "a", "an", "and", "are", "as", "at", "be", "but", "by",
	    "for", "if", "in", "into", "is", "it",
	    "no", "not", "of", "on", "or", "such",
	    "that", "the", "their", "then", "there", "these",
	    "they", "this", "to", "was", "will", "with"
	  };
	
	public CleanIndexWriter(IndexId iid) throws IOException{
		this.iid = iid;		
		this.builder = new FieldBuilder("",FieldBuilder.Case.IGNORE_CASE,FieldBuilder.Stemmer.NO_STEMMER,FieldBuilder.Options.SPELL_CHECK);
		this.langCode = GlobalConfiguration.getInstance().getLanguage(iid.getDBname());
		HashSet<String> stopWords = new HashSet<String>();
		if(langCode.equals("en")){
			for(String w : ENGLISH_STOP_WORDS)
				stopWords.add(w);
		} else{
			stopWords.addAll(HighFreqTerms.getHighFreqTerms(iid.getDB(),"contents",20));
		}
		log.info("Using phrase stopwords: "+stopWords);
		builder.getBuilder().getFilters().setStopWords(stopWords);
		String pathMain = iid.getSpellWords().getTempPath();
		//String pathAll = iid.getSpellTitles().getTempPath();
		writerMain = open(pathMain);
		//writerAll = open(pathAll);			
		addMetadata(writerMain,"stopWords",stopWords);
	}
	
	protected IndexWriter open(String path) throws IOException {
		IndexWriter writer;
		try {
			writer = new IndexWriter(path,null,true); // always make new index
		} catch (IOException e) {				
			try {
				// try to make brand new index
				WikiIndexModifier.makeDBPath(path); // ensure all directories are made
				log.info("Making new index at path "+path);
				writer = new IndexWriter(path,null,true);
			} catch (IOException e1) {
				log.error("I/O error openning index for addition of documents at "+path+" : "+e.getMessage());
				throw e1;
			}				
		}
		writer.setMergeFactor(20);
		writer.setMaxBufferedDocs(500);		
		writer.setUseCompoundFile(true);
		writer.setMaxFieldLength(WikiIndexModifier.MAX_FIELD_LENGTH);
		
		return writer;
	}

	/** Add to index used for spell_words */
	public void addMainArticle(Article a){
		if(a.getNamespace().equals("0"))
			addArticle(a,writerMain);
	}
	/** Add to inde used for spell_titles */
	public void addAllArticle(Article a){
		//addArticle(a,writerAll);
	}
	
	/** Add single article */
	protected void addArticle(Article a, IndexWriter writer){
		if(!WikiIndexModifier.checkAddPreconditions(a,langCode))
			return; // don't add if preconditions are not met

		Object[] ret = WikiIndexModifier.makeDocumentAndAnalyzer(a,builder,iid);
		Document doc = (Document) ret[0];
		Analyzer analyzer = (Analyzer) ret[1];
		try {
			writer.addDocument(doc,analyzer);
			log.debug(iid+": Adding document "+a);
		} catch (IOException e) {
			log.error("I/O Error writing articlet "+a+" to index "+writer);
		} catch(Exception e){
			e.printStackTrace();
			log.error("Error adding document "+a+" with message: "+e.getMessage());
		}
	}
	
	/** Close and optimize index 
	 * @throws IOException */
	public void close() throws IOException{
		try{
			writerMain.optimize();
			writerMain.close();
			//writerAll.optimize();
			//writerAll.close();
		} catch(IOException e){
			log.warn("I/O error optimizing/closing index at "+iid.getTempPath());
			throw e;
		}
	}
	
	/** 
	 * Add into metadata_key and metadata_value. 
	 * Collection is assumed to contain words (without spaces) 
	 */
	public void addMetadata(IndexWriter writer, String key, Collection<String> values){
		StringBuilder sb = new StringBuilder();
		// serialize by joining with spaces
		for(String val : values){
			if(sb.length() != 0)
				sb.append(" ");
			sb.append(val);
		}
		Document doc = new Document();
		doc.add(new Field("metadata_key",key, Field.Store.YES, Field.Index.UN_TOKENIZED));
		doc.add(new Field("metadata_value",sb.toString(), Field.Store.YES, Field.Index.NO));
		
		try {
			writer.addDocument(doc);
		} catch (IOException e) {
			log.warn("Cannot write metadata : "+e.getMessage());
		}
	}
}
