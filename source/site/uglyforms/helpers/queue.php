<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsHelperQueue extends UglyformsHelper
{
	public static function enqueue($input, $data, $attachments, $actions = array())
	{		
		if(empty($actions)){
			$actions = UglyformsHelperAction::getApplicableActions('', $input);
		}
		
		//save this data in params
		//TODO : what about attachments, should maintain in db or what???
		$submitted_data = json_encode(array('data'=>$data, 'attachments'=>$attachments));
		
		$queueRecords = array();
		foreach ($actions as $action){
			$queue = UglyformsQueue::getInstance();
			$queue->set('input_id',     $input->getId())
				  ->set('action_id',    $action->getId())
				  ->set('approved',     !$action->getParam('require_approval', 1))
				  ->set('approval_key', !($queue->isApproved()) ? md5($action->getId().$action->getType().time()) : '')
				  ->setParam('submitted_data', $submitted_data)
				  ->save();
			
			$queueRecords[$queue->getId()]  =  $queue;
		}
		
		return $queueRecords;
	}
	
	//update the token value of the queue record
	public static function updateToken($records, $token)
	{
		foreach ($records as $record){
			$record->set('token', $token)
					   ->save();
		}
		
		return true;
	}
	
	public static function appendDataToFile($records, $data, $attachments)
	{
		$token   	=  md5(serialize($data).time());
		$dataToDump = '{'.$token.'}'.json_encode(array('data'=>$data, 'attachments'=>$attachments)).'{/'.$token.'}';
		$bucketPath = UglyformsHelperConfig::get('bucket_path');
		$bucket		= UglyformsHelperConfig::get('current_bucket');	

		$bucketPath = empty($bucketPath) ? UGLYFORMS_PATH_BUCKET_ROOT : $bucketPath;
		$bucket		= empty($bucket)? UGLYFORMS_BUCKET_NAME : $bucket;
		
		$bucketPath = UglyformsHelperQueue::getBucket($bucketPath, $bucket).'/';

		$recordIds  = array_keys($records);
		
		$file = self::getFile($recordIds, $bucketPath);
		
		if($file === false){
			//JXITODO : Error log No file found to append data
			return false;
		}
		
		list($fp, $filename, $lock) = $file;
		
		fseek($fp, 0, SEEK_END); // move the file point to end-of-file
	    $fileIndex  = ftell($fp);
	    $result 	= fwrite($fp, $dataToDump);
	    
		//release the lock after writing content
	    $lock->releaseLock();
	    fclose($fp);
	    
		//if unable to write data in the file then continue with next filename
	    if($result===false){
	    	//JXITODO : create error log that unable to write content in file
	    	return false;
	    }
	    
	    $queueToken = json_encode(array('filename'=>$bucketPath.$filename, 'token'=>$token, 'filepointer'=>$fileIndex, 'length'=>strlen($dataToDump)));
		return self::updateToken($records, $queueToken);
	}	
	
	public static function getBucket($bucketPath, $bucketname)
	{
		$bucket_size = 0;
		$path 		 = $bucketPath.$bucketname;
	    $files 		 = JFolder::files(JPATH_SITE.$path);
	    
	    foreach($files as $file) {
	         $bucket_size += filesize(JPATH_SITE.$path . "/" . $file);
	    }
	    
	    if($bucket_size >= UGLYFORMS_BUCKET_CAPACITY){
	    	$lock  =  UglyformsLock::getInstance('switchingBucket');
	    	if(!$lock->getLockResult()){	
	    		return $path;
	    	}
	    	
	    	$bucketNumber 	= (substr($bucketname, 6)+1);
	    	$newBucketname  = 'bucket'.$bucketNumber;
	    	
	    	if(!JFolder::exists(JPATH_SITE.$bucketPath.$newBucketname)){
	    	 	$create = JFolder::create(JPATH_SITE.$bucketPath.$newBucketname);
	    	 	
		    	if($create === false){
		    		//JXITODO : error log..unable to create directory
		    		$lock->releaseLock();
		    		return $path;
		    	}
		    	//create index.html file in new directory		    	
		    	JFile::write(JPATH_SITE.$bucketPath.$newBucketname.'/index.html', $buffer);
	    	}
	    	
	    	$model = UglyformsFactory::getInstance('config', 'model');
			$model->save(array('current_bucket'=>$newBucketname));
			$lock->releaseLock();
	    	
			//JXITODO : Bucket has been switched (Info Log)
			return $bucketPath.$newBucketname;
	    }
	    
	    return $path;
	}
		
	
	/**
	 * This function will return the filepointer, filename 
	 * and lock for the file which will be used for data writing
	 * 
	 * @param array $recordIds array of ids(array of queue-ids or array of any random number to generate new filename) 
	 * @param string $bucketPath path where to look for the files
	 * @return mixed array of filepointer, filename name and its lock
	 */
	public static function getFile($recordIds, $bucketPath)
	{
		if(empty($recordIds)){
			//JXITODO : error log for no records to insert
			return false;
		}
		
		static $retryCount = 0;
		$fileReserved  = false;
		
		//records : array of queue-id's only
		foreach ($recordIds as $recordId){
			$filename = 'queuelog_'.($recordId % UGLYFORMS_BUCKET_MAX_FILE_COUNT).'.txt';
			$fp = fopen(JPATH_SITE.$bucketPath.$filename, "a+");
			if($fp === false){
				continue;
			}
			
			$lock =  UglyformsLock::getInstance($filename);
			if(!$lock->getLockResult()){
				fclose($fp);
				continue;
			}
			
			$fileReserved = true;
			break;
		}
		
		//if fp is reserved by succefully locking the file
		//IMP : filereserved variable is added to identify whether the foreach loop returned filepointer after locking or not
		if(($fp !== false) && $fileReserved){
			return array($fp, $filename, $lock);
		}
		
		//if no file found to write data then retry to get the available file
		if($retryCount < 10 ){
			$retryCount++;
			
			$randomNumber = array(rand(0, 31));
			return self::getFile($randomNumber, $bucketPath);
		}
		
		return false;
	}
	
	public static function sendApprovalEmail($approvalMessage, $subject = 'COM_UGLYFORMS_QUEUE_APPROVAL_SEND_EMAIL_SUBJECT')
	{
		$subject  =  Rb_Text::_($subject);
		$emails   =  UglyformsHelperConfig::get('approval_send_email_to');
		$emails   =  empty($emails) ? array() : explode(',', $emails);
		
		$emailgroup = UglyformsHelperConfig::get('approval_send_email_group');
		
		//get users by group
		if(!empty($emailgroup)){
			$userIds  	= array();
			foreach ($emailgroup as $groupId){
				$userIds  	   =  UglyformsHelperJoomla::getUsersByGroup($groupId);
				$userEmails    =  UglyformsHelperJoomla::getEmailById($userIds); 
				$emails 	   =  empty($userEmails) ? $emails : array_merge($emails, $userEmails);
			}
		}

		return UglyformsHelperUtils::sendEmail($subject, $approvalMessage, null, $emails);
	}
	
	public static function getApprovedUnprocessedRecords()
	{
		$filter  = array('approved'=>1, 'status' => array(array('IN', '('.UglyformsQueue::STATUS_NONE.','.UglyformsQueue::STATUS_WAITING.')')));
		$records = UglyformsFactory::getInstance('queue', 'model')
									->loadRecords($filter);
									
		return $records;
	}
	
	public static function fetchData($token, $assoc=null)
	{
		$token  		= json_decode($token, $assoc);
		$content 		= file_get_contents(JPATH_SITE.$token['filename'], null, null, $token['filepointer'], $token['length']);
		
		$regex = '#{'.$token['token'].'}(.*?){/'.$token['token'].'}#s';
		preg_match($regex,$content,$matches);
		
		if(empty($matches[1])){
			//JXITODO : read complete file with ref to the token value and update relevant data value
		}
		
		$relevant_data = json_decode($matches[1], true);

		return $relevant_data;
	}
}