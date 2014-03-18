<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class UglyformsAdminViewQueue extends UglyformsAdminBaseViewQueue
{
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		Rb_HelperToolbar::cancel();
	}
	
	public function display($tpl = null)
	{
		// get all inputs
		$inputs = UglyformsHelperInput::get();
		$this->assign('inputs', $inputs);
		
		// get all actions
		$actions = UglyformsHelperAction::get();
		$this->assign('actions', $actions);
		
		// get status list of queue
		$queue_status_list = UglyformsQueue::getStatusList();
		$this->assign('queue_status_list', $queue_status_list);
		return parent::display($tpl);
	}

	public function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$queue   =  UglyformsQueue::getInstance($itemId);
		
		$recorded_data = $queue->getInputData();

		$relevant_data = ($recorded_data == false) ? 
									array('data'=>array(), 'attachment'=>array()) 
										: array('data'=>$recorded_data->data, 'attachment'=>$recorded_data->attachment);
		
		$this->assign('queue', 				$queue);
		$this->assign('input', 				UglyformsHelperInput::get($queue->getInput()));
		$this->assign('action',  			UglyformsHelperAction::get($queue->getAction()));
		$this->assign('status', 			UglyformsQueue::getStatusList());
		$this->assign('form',  				$queue->getModelform()->getForm($queue));
		$this->assign('queue_data',  		$relevant_data['data']);
		$this->assign('queue_attachments',  $relevant_data['attachment']);
				
		return true;
	} 
}
