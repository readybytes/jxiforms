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
									  ->set('approval_key', !($queue->getApproved()) ? md5($action->getId().$action->getType().time()) : '')
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

			//if task is approved then process immediately   
			if($record->getApproved()){
				$record->process();
			}
		}
		
		return true;
	}
	
	public static function appendDataToFile($records, $data, $attachments)
	{
		$token   	=  md5(serialize($data).time());
		$dataToDump = '{'.$token.'}'.json_encode(array('data'=>$data, 'attachments'=>$attachments)).'{/'.$token.'}';		
		$bucketPath = JXiFormsHelperConfig::get('bucket_path').JXiFormsHelperConfig::get('current_bucket').'/';
		
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
}