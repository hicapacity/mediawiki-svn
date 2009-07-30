<?php
class WahJobManager {
	//encoding profiles (settings set in config)

	function __construct(&$file, $encodeKey){
		$this->file = $file;
		$this->sEncodeKey = $encodeKey;
		$this->sNamespace =$this->file->title->getNamespace();
		$this->sTitle = $this->file->title->getDBkey();
	}

	/*
	 * get the percentage done (return 1 if done)
	 */
	function getDonePerc(){
		$fname = 'WahJobManager::getDonePerc';
		//grab the jobset
		$dbr = &wfGetDb( DB_READ );
		$res = $dbr->select('wah_jobset',
			'*',
			array(
				'set_namespace' => $this->sNamespace,
				'set_title'		=> $this->sTitle,
				'set_encodekey'	=> $this->sEncodeKey
			),
			__METHOD__
		);
		if( $dbr->numRows( $res ) == 0 ){
			//we should setup the job:
			$this->doJobSetup();
			//return 0 percent done
			return 0;
		}else{
			$setRow = $dbr->fetchObject( $res );
			$this->sId = $setRow->set_id;
			$this->sJobsCount = $setRow->set_jobs_count;
			//get an estimate of how many of the current job are NULL (not completed)
			$doneRes = $dbr->select('wah_jobqueue',
				'job_id',
				array(
					'job_set_id' => $this->sId,
					'job_done_time IS NOT NULL'
				),
				$fname
			);
			$doneCount = $dbr->numRows( $doneRes );
			if( $doneCount == $this->sJobsCount )
				return 1;
			//return 1 when doneCount == sJobCount
			//(we also set this at a higher level and avoid hitting the wah_jobqueue table alltogehter)
			return round( $doneCount / $this->sJobsCount , 3);
		}
	}
	/*
	 * returns a new job
	 *
	 * @param prefered jobset id
	 *
	 * returns the jobs object or false if no jobs are available
	 */
	static function getNewJob( $jobset_id = false ){
		global $wgNumberOfClientsPerJobSet, $wgJobTimeOut, $wgUser;
		$dbr = wfGetDb( DB_READ );
		//check if we have jobset
		//its always best to assigning from jobset (since the user already has the data)
		if( $jobset_id ){
			//try to get one from the current jobset
			$res = $dbr->select( 'wah_jobqueue',
				'*',
				array(
					'job_set_id' =>  intval( $jobset_id ),
					'job_done_time IS NULL',
					'job_last_assigned_time < '.  $dbr->addQuotes( time() - $wgJobTimeOut )
				),
				__METHOD__,
				array(
					'LIMIT'=>1
				)
			);
			if( $dbr->numRows( $res ) != 0){
				$job = $dbr->fetchObject( $res );
				return WahJobManager::assignJob( $job );
			}
		}
		
		//check if we already have a job given but never completed:
		$res = $dbr->select( 'wah_jobqueue',
			'*',
			array(
				'job_last_assigned_user_id' => $wgUser->getId()
			),
		 	__METHOD__,
			array(
				'LIMIT'=>1
			)
		);
		//re-assing the same job (don't update
		if( $dbr->numRows( $res ) != 0){
			$job = $dbr->fetchObject( $res );
			return WahJobManager::assignJob( $job , false, false);	
		}
		
		//just do a normal select from jobset
		$setRes = $dbr->select( 'wah_jobset',
			'*',
			array(
				'set_done_time IS NULL',
				'set_client_count < '.  $dbr->addQuotes( $wgNumberOfClientsPerJobSet )
			),
			__METHOD__,
			array(
				'LIMIT'		=> 1
			)
		);
		if( $dbr->numRows( $setRes ) == 0){
			//no jobs:			
			return false;
		}else{
			//get a job from the jobset and increment the set_client_count
			//(if the user has an unfinished job) re assign it (in cases where job is lost in trasport)
			$jobSet = $dbr->fetchObject( $setRes );
			//get a job from the selected jobset:
			$jobRes = $dbr->select('wah_jobqueue', '*',
					array(
						'job_set_id' => $jobSet->set_id,
						'job_done_time IS NULL',
						'job_last_assigned_time IS NULL OR job_last_assigned_time < ' . 
							 $dbr->addQuotes( time() - $wgJobTimeOut ) 
					),
					__METHOD__,
					array(
						'LIMIT'		=> 1
					)
			);
			if( $dbr->numRows( $jobRes ) == 0){				
				//no jobs in this jobset (return nojob)
				//@@todo we could "retry" since we will get here when a set has everything assigned in less than $wgJobTimeOut
				return false;
			}else{
				$job =  $dbr->fetchObject( $jobRes );
				return WahJobManager::assignJob( $job , $jobSet);
			}
		}
	}
	/*
	 * assigns a job:
	 *
	 * @param $job result object
	 *
	 * returns $job result object;
	 */
	static function assignJob( & $job, $jobSet = false, $doUpdate=true ){
		global $wgUser;
		$dbr = wfGetDb( DB_READ );
		$dbw = wfGetDb( DB_WRITE );
		if( $jobSet == false ){
			$jobSet = self::getJobSetBySetId( $job->job_set_id );
		}
		//set the title and namespace:
		$job->title = $jobSet->set_title;
		$job->ns	= $jobSet->set_namespace;
		
		//check if we should update the tables for the assigned Job
		if( $doUpdate ){
			//for jobqueue update: job_last_assigned_time, job_last_assigned_user_id, job_assign_count
			$dbw->update('wah_jobqueue',
				array(
					'job_last_assigned_time'	=> time(),
					'job_last_assigned_user_id'	=> $wgUser->getId(),
					'job_assign_count' 			=> $job->job_assign_count ++
				),
				array(
					'job_id'	=> $job->job_id
				),
				__METHOD__,
				array(
					'LIMIT'	=>	1
				)
			);
			//for jobset update: set_client_count  (if job was not previously assigned)
			//and if jobset is present (most repeat clients should have the data already)
			if( $jobSet && is_null( $job->job_last_assigned_user_id ) ){
				$dbw->update('wah_jobset',
					array(
						'set_client_count' => $jobSet->set_client_count ++
					),
					array(
						'set_id'	=>	$job->job_set_id
					),
					__METHOD__,
					array(
						'LIMIT'	=>	1
					)
				);
			}
		}
		return $job;
	}
	static function getJobSetBySetId( $set_id ){
		$dbr = wfGetDb( DB_READ );
		$setRes = $dbr->select('wah_jobset', '*',
			array(
				'set_id' => $set_id
			),
			__METHOD__,
			array(
				'LIMIT'		=> 1
			)
		);
		$jobSet = $dbr->fetchObject( $setRes );
		return $jobSet;
	}
	/*
	 * setups up a new job
	 */
	function doJobSetup(){
		global $wgChunkDuration, $wgDerivativeSettings;
		$fname = 'WahJobManager::doJobSetup';
		$dbw = &wfGetDb( DB_WRITE );
		//figure out how many sub-jobs we will have:
		$length = $this->file->handler->getLength( $this->file );

		$set_job_count = ceil( $length / $wgChunkDuration );

		//first insert the job set
		$dbw->insert('wah_jobset',
			array(
				'set_namespace' 	=> $this->sNamespace,
				'set_title'			=> $this->sTitle,
				'set_jobs_count' 	=> $set_job_count,
				'set_encodekey'		=> $this->sEncodeKey,
			  	'set_creation_time' => time()
			),$fname
		);
		$this->sId = $dbw->insertId();

		//generate the job data
		$jobInsertArray = array();
		for( $i=0 ; $i < $set_job_count; $i++ ){
			$encSettingsAry = $wgDerivativeSettings[ $this->sEncodeKey ];
			$encSettingsAry['starttime'] = $i * $wgChunkDuration;
			//should be oky that the last endtime is > than length
			$encSettingsAry['endtime']	 = $encSettingsAry['starttime'] + $wgChunkDuration;

			$jobJsonAry = array(
				'jobType'		=> 'transcode',				
				'chunkNumber'	=> $i,
				'encodeSettings'=> $encSettingsAry
			);

			//add starttime and endtime
			$jobInsertArray[] =
				array(
					'job_set_id' => $this->sId,					
					'job_json'	 => ApiFormatJson::getJsonEncode( $jobJsonAry )
				);
		}
		//now insert the jobInsertArray
		$dbw->insert( 'wah_jobqueue', $jobInsertArray, $fname );
	}

}

?>