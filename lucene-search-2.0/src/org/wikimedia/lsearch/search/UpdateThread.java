package org.wikimedia.lsearch.search;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Map.Entry;

import org.apache.log4j.Logger;
import org.apache.lucene.index.Term;
import org.apache.lucene.queryParser.ParseException;
import org.apache.lucene.search.BooleanClause;
import org.apache.lucene.search.BooleanQuery;
import org.apache.lucene.search.IndexSearcher;
import org.apache.lucene.search.Query;
import org.apache.lucene.search.TermQuery;
import org.wikimedia.lsearch.analyzers.Analyzers;
import org.wikimedia.lsearch.analyzers.WikiQueryParser;
import org.wikimedia.lsearch.beans.LocalIndex;
import org.wikimedia.lsearch.config.Configuration;
import org.wikimedia.lsearch.config.GlobalConfiguration;
import org.wikimedia.lsearch.config.IndexId;
import org.wikimedia.lsearch.config.IndexRegistry;
import org.wikimedia.lsearch.interoperability.RMIMessengerClient;
import org.wikimedia.lsearch.interoperability.RMIServer;


/**
 * Thread that periodically check indexer hosts for index updates. 
 * 
 * @author rainman
 *
 */
public class UpdateThread extends Thread {
	static org.apache.log4j.Logger log = Logger.getLogger(UpdateThread.class);
	protected RMIMessengerClient messenger;
	protected GlobalConfiguration global;
	protected IndexRegistry registry;
	protected long queryInterval;
	protected SearcherCache cache;
	
	protected static UpdateThread instance = null;
	
	@Override
	public void run() {
		long lastCheck, now;
		while(true){
			lastCheck = System.currentTimeMillis();
			checkForUpdate();
			now = System.currentTimeMillis(); 
			if((now-lastCheck) < queryInterval){
				try {
					// try to check for updates in regular intervals
					Thread.sleep(queryInterval - (now-lastCheck));
				} catch (InterruptedException e) {
					// do nothing
				}
			}
		}
	}
	
	protected void checkForUpdate(){
		HashSet<IndexId> iids = global.getMySearch();
		HashMap<String,ArrayList<IndexId>> hostMap = new HashMap<String,ArrayList<IndexId>>();
		ArrayList<LocalIndex> forUpdate = new ArrayList<LocalIndex>();
		
		// organize into hostmap: host -> iids (indexes at that host)
		for(IndexId iid : iids){
			String host = iid.getIndexHost();
			ArrayList<IndexId> hostiids = hostMap.get(host);
			if(hostiids == null){
				hostiids = new ArrayList<IndexId>();
				hostMap.put(host,hostiids);
			}
			hostiids.add(iid);			
		}		
		// check for new snapshots
		for(Entry<String,ArrayList<IndexId>> hostiid : hostMap.entrySet()){
			ArrayList<IndexId> hiids = hostiid.getValue();
			String host = hostiid.getKey();
			long[] timestamps = messenger.getIndexTimestamp(hiids, host);
			if(timestamps == null)
				continue;
			
			for(int i = 0; i < hiids.size(); i++){
				IndexId iid = hiids.get(i);
				LocalIndex myli = registry.getCurrentSearch(iid);
				if(timestamps[i]!= 0 && (myli == null || myli.timestamp < timestamps[i])){
					LocalIndex li = new LocalIndex(
							iid,
							iid.getUpdatePath(),
							timestamps[i]);
					forUpdate.add(li); // newer snapshot available
				}
			}
		}
		// get the new snapshots via rsync, might be lengthy
		for(LocalIndex li : forUpdate){
			log.debug("Syncing "+li.iid);
			rebuild(li); // rsync, update registry, cache
		}
	}
	
	/** Rsync a remote snapshot to a local one, updates registry, cache */
	protected void rebuild(LocalIndex li){
		final String sep = Configuration.PATH_SEP;
		String command;
		IndexId iid = li.iid;		
		// update path:  updatepath/timestamp
		String updatepath = iid.getUpdatePath();
		if(!updatepath.endsWith(Configuration.PATH_SEP))
			updatepath += Configuration.PATH_SEP;
		updatepath += li.timestamp;
		
		li.path = updatepath;
		
		// cleanup the update dir for this iid
		File spd = new File(iid.getUpdatePath());
		LocalIndex myli = registry.getCurrentSearch(iid);
		if(myli!=null){
			String current = Long.toString(myli.timestamp);
			if(spd.exists() && spd.isDirectory()){
				File[] files = spd.listFiles();
				for(File f: files){
					if(!f.getName().equals(current))
						deleteDirRecursive(f);
				}
			}
		}
		new File(updatepath).mkdirs();
		try{
			// if local, use cp -lr instead of rsync
			if(global.isLocalhost(iid.getIndexHost())){
				command = "/bin/cp -lr "+iid.getSnapshotPath()+sep+li.timestamp+" "+iid.getUpdatePath();
				log.debug("Running shell command: "+command);
				Runtime.getRuntime().exec(command).waitFor();
			} else{
				File ind = new File(iid.getCanonicalSearchPath());

				if(ind.exists()){ // prepare a local hard-linked copy of index
					/* TODO: this might work.. need to be tested 
					String command = "/bin/cp -lr "+ind.getCanonicalPath()+" "+updatepath;
					log.debug("Running shell command: "+command);
					Runtime.getRuntime().exec(command).waitFor(); */
					
					ind = ind.getCanonicalFile();
					for(File f: ind.listFiles()){
						//  a cp -lr command for each file in the index
						command = "/bin/cp -lr "+ind.getCanonicalPath()+sep+f.getName()+" "+updatepath+sep+f.getName();
						Process copy;
						try {
							log.debug("Running shell command: "+command);
							copy = Runtime.getRuntime().exec(command);
							copy.waitFor();
						} catch (Exception e) {
							log.error("Error making update hardlinked copy "+updatepath+": "+e.getMessage());
							continue;
						}
					}
				}

				// rsync
				String snapshotpath = iid.getRsyncSnapshotPath()+"/"+li.timestamp;
				command = "/usr/bin/rsync --delete -r rsync://"+iid.getIndexHost()+":"+snapshotpath+" "+iid.getUpdatePath();
				log.debug("Running shell command: "+command);
				Runtime.getRuntime().exec(command).waitFor();

			}

			// make the search path if it doesn't exist
			File searchpath = new File(iid.getSearchPath()).getParentFile();
			if(!searchpath.exists())
				searchpath.mkdir();

			// check if updated index is a valid one (throws an exception on error)
			IndexSearcherMul is = new IndexSearcherMul(li.path);
			
			// refresh the symlink
			command = "/bin/rm -rf "+iid.getSearchPath();
			log.debug("Running shell command: "+command);
			Runtime.getRuntime().exec(command).waitFor();
			command = "/bin/ln -fs "+updatepath+" "+iid.getSearchPath();
			log.debug("Running shell command: "+command);
			Runtime.getRuntime().exec(command).waitFor();
			
			// update registry, cache, rmi object
			registry.refreshUpdates(iid);
			updateCache(is,li);
			RMIServer.rebind(iid);
			registry.refreshCurrent(li);
			
			// notify all remote searchers of change
			messenger.notifyIndexUpdated(iid,iid.getDBSearchHosts());
			
		} catch(IOException ioe){
			log.error("I/O error on index "+iid+" at "+li.path);
		} catch (InterruptedException e) {
			log.error("Failed to complete rsync of: "+updatepath);
		}
	}
	
	/** Update search cache after successful rsync of update version of index */
	protected void updateCache(IndexSearcherMul is, LocalIndex li){
		// do some typical queries to preload some lucene caches, pages into memory, etc..
		warmupIndexSearcher(is,li.iid);			
		// add to cache
		cache.invalidateLocalSearcher(li.iid,is);		
	}
	
	/** Runs some typical queries on a local index searcher to preload caches, pages into memory, etc .. */
	public static void warmupIndexSearcher(IndexSearcherMul is, IndexId iid){
		try{
			WikiQueryParser parser = new WikiQueryParser("contents","main",Analyzers.getSearcherAnalyzer(iid),WikiQueryParser.NamespacePolicy.IGNORE);
			Query q = parser.parseTwoPass("a OR very OR long OR title OR involving OR both OR wikipedia OR and OR pokemons",WikiQueryParser.NamespacePolicy.IGNORE);
			is.search(q,new NamespaceFilterWrapper(new NamespaceFilter("0")));
		} catch (IOException e) {
			log.error("Error warming up local IndexSearcherMul for "+iid);
		} catch (ParseException e) {
			log.error("Error parsing query in warmup of IndexSearcherMul for "+iid);
		}
	}
	
	protected UpdateThread(){
		messenger = new RMIMessengerClient();
		global = GlobalConfiguration.getInstance();
		registry = IndexRegistry.getInstance();
		Configuration config = Configuration.open();
		// query interval in config is in minutes
		queryInterval = config.getInt("Search","queryinterval",15) * 60 * 1000;
		cache = SearcherCache.getInstance();
		
	}
	
	public static synchronized UpdateThread getInstance(){
		if(instance == null)
			instance = new UpdateThread();
		
		return instance;
	}
	
	protected void deleteDirRecursive(File file){
		if(!file.exists())
			return;
		else if(file.isDirectory()){
			File[] files = file.listFiles();
			for(File f: files)
				deleteDirRecursive(f);
			file.delete();
			log.debug("Deleted old update at "+file);
		} else{
			file.delete();			
		}
	}
}
