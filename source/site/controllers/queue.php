<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsSiteControllerQueue extends UglyformsController
{
	public function approve()
	{
		$queueId = $this->_getId();
		$queue   = ($queueId != 0) ?  UglyformsQueue::getInstance($queueId) : false; 
		
		if(!($queue instanceof UglyformsQueue)){
			throw new Exception(Rb_Text::sprintf('COM_UGLYFORMS_EXCEPTION_INVALID_QUEUE_ID', $queueId));
		}
		
		//if queue is processed OR already approved then do nothing 
		if(($queue->getStatus() === UglyformsQueue::STATUS_PROCESSED) || ($queue->isApproved())){
			$this->setRedirect('index.php', Rb_Text::_('COM_UGLYFORMS_QUEUE_EITHER_QUEUE_PROCESSED_OR_APPROVED'));
			return false;
		}

		$queue_approval_key  =  $queue->getApprovalKey();
		$approval_key = UglyformsFactory::getApplication()->input->get('approval_key', '');
		
		if(strcmp($queue_approval_key, $approval_key) !== 0){
			$this->setRedirect('index.php', Rb_Text::_('COM_UGLYFORMS_QUEUE_INVALID_QUEUE_APPROVAL_KEY'));
			return false;
		}
		
		//JXITODO :check whether user is authorized to approve this action
		$queue->approve();
		
		$this->setRedirect('index.php', Rb_Text::_('COM_UGLYFORMS_QUEUE_TASK_APPROVED'));
		return false;	
	}
}