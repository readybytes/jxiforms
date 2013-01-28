<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteControllerQueue extends JXiFormsController
{
	public function approve()
	{
		$queueId = $this->_getId();
		$queue   = ($queueId != 0) ?  JXiformsQueue::getInstance($queueId) : false; 
		
		if(!($queue instanceof JXiformsQueue)){
			throw new Exception(Rb_Text::sprintf('COM_JXIFORMS_EXCEPTION_INVALID_QUEUE_ID', $queueId));
		}
		
		//if queue is processed OR already approved then do nothing 
		if(!($queue->getStatus() === JXiformsQueue::STATUS_PROCESSED) || ($queue->getApproved())){
			return true;
		}

		$queue_approval_key  =  $queue->getApprovalKey();
		$approval_key = JXiFormsFactory::getApplication()->input->get('approval_key', '');
		
		if(strcmp($queue_approval_key, $approval_key) !== 0){
			//JXITODO : display proper message when approval key does not match
			return true;
		}
		
		//JXITODO :check whether user is authorized to approve this action
		$queue->approve();
		
		JXiFormsFactory::getApplication()->redirect('index.php', Rb_Text::_('COM_JXIFORMS_QUEUE_TASK_APPROVED'));	
	}
}