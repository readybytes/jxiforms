<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsHelperQueue extends JXiFormsHelper
{
	public static function enqueue($input, $actions = array())
	{		
		if(empty($actions)){
			$actions = JXiFormsHelperAction::getApplicableActions('', $input);
		}
		
		$queueRecords = array();
		foreach ($actions as $action){
			$queue = JXiformsQueue::getInstance();
			$queueRecords[] = $queue->set('input_id',     $input->getId())
									  ->set('action_id',    $action->getId())
									  ->set('approved',     !$action->getParam('require_approval', 1))
									  ->set('approval_key', !($queue->isApproved()) ? md5($action->getId().$action->getType().time()) : '')
									  ->save();
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
		$bucketPath = JXiFormsHelperConfig::get('bucket_path');
		$bucket		= JXiFormsHelperConfig::get('current_bucket');	

		$bucketPath = empty($bucketPath) ? JXIFORMS_PATH_BUCKET_ROOT : $bucketPath;
		$bucket		= empty($bucket)? JXIFORMS_BUCKET_NAME : $bucket;
		
		$bucketPath = $bucketPath.$bucket.'/';
		
		$filename   = '';
		foreach ($records as $record){
			$filename = 'queuelog_'.($record->getId() % 32).'.txt'; //Use constant
			$fp = fopen(JPATH_SITE.$bucketPath.$filename, "a+");
			if($fp === false){
				continue;
			}
					
			if(!flock($fp, LOCK_EX)) {
				fclose($fp);
				continue;
			}
			
		    fseek($fp, 0, SEEK_END); // move the file point to end-of-file
		    $fileIndex = ftell($fp);
		    $result = fwrite($fp, $dataToDump);
		    flock($fp, LOCK_UN);
		    fclose($fp);
		    
		    //if unable to write data in the file then continue with next filename
		    if($result===false){
		    	continue;
		    }
		    
		    $queueToken = json_encode(array('filename'=>$bucketPath.$filename, 'token'=>$token, 'filepointer'=>$fileIndex, 'length'=>strlen($dataToDump)));
		    self::updateToken($records, $queueToken);
		    
		    break;
		}
	}	
	
	public static function sendApprovalEmail($approvalMessage, $subject = 'COM_JXIFORMS_QUEUE_APPROVAL_SEND_EMAIL_SUBJECT')
	{
		$subject  =  Rb_Text::_($subject);
		$emails   =  JXiFormsHelperConfig::get('approval_send_email_to');
		$emails   =  empty($emails) ? array() : explode(',', $emails);
		
		$emailgroup = JXiFormsHelperConfig::get('approval_send_email_group');
		
		//get users by group
		if(!empty($emailgroup)){
			$userIds  	= array();
			foreach ($emailgroup as $groupId){
				$userIds  	   =  JXiFormsHelperJoomla::getUsersByGroup($groupId);
				$userEmails    =  JXiFormsHelperJoomla::getEmailById($userIds); 
				$emails 	   =  empty($userEmails) ? $emails : array_merge($emails, $userEmails);
			}
		}

		return JXiFormsHelperUtils::sendEmail($subject, $approvalMessage, null, $emails);
	}
	
	public static function getApprovedUnprocessedRecords()
	{
		$filter  = array('approved'=>1, 'status' => array(array('IN', '('.JXiformsQueue::STATUS_NONE.','.JXiformsQueue::STATUS_WAITING.')')));
		$records = JXiFormsFactory::getInstance('queue', 'model')
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