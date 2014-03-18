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
	public static function enqueue($input, $data_id, $actions = array())
	{		
		if(empty($actions)){
			$actions = UglyformsHelperAction::getApplicableActions('processor', $input);
		}
		
		//save this data in params
		//TODO : what about attachments, should maintain in db or what???
		
		$queueRecords = array();
		foreach ($actions as $action){
			$queue = UglyformsQueue::getInstance();
			$queue->set('input_id',     $input->getId())
				  ->set('action_id',    $action->getId())
				  ->set('approved',     !$action->getParam('require_approval', 1))
				  ->set('approval_key', !($queue->isApproved()) ? md5($action->getId().$action->getType().time()) : '')
				  ->set('data_id', $data_id)
				  ->save();
			
			$queueRecords[$queue->getId()]  =  $queue;
		}
		
		return $queueRecords;
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
}