<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsAdminViewQueue extends JXiFormsAdminBaseViewQueue
{
	protected function _adminGridToolbar()
	{
		JToolbarHelper::deleteList(JText::_('COM_JXIFORMS_JS_ARE_YOU_SURE_TO_DELETE'));
	}
	
	protected function _adminEditToolbar()
	{
		JToolbarHelper::cancel();
	}
	
	public function display($tpl = null)
	{
		// get all inputs
		$inputs = JXiFormsHelperInput::get();
		$this->assign('inputs', $inputs);
		
		// get all actions
		$actions = JXiFormsHelperAction::get();
		$this->assign('actions', $actions);
		
		// get status list of queue
		$queue_status_list = JXiformsQueue::getStatusList();
		$this->assign('queue_status_list', $queue_status_list);
		return parent::display($tpl);
	}
	
	function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$queue   =  JXiformsQueue::getInstance($itemId);
		
		$relevant_data = JXiFormsHelperQueue::fetchData($queue->getToken(), true);		
		
		$this->assign('queue', 				$queue);
		$this->assign('input', 				JXiFormsHelperInput::get($queue->getInput()));
		$this->assign('action',  			JXiFormsHelperAction::get($queue->getAction()));
		$this->assign('status', 			JXiformsQueue::getStatusList());
		$this->assign('form',  				$queue->getModelform()->getForm($queue));
		$this->assign('queue_data',  		$relevant_data['data']);
		$this->assign('queue_attachments',  $relevant_data['attachments']);
				
		return true;
	} 
}