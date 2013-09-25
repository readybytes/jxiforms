<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		joomlaxi@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewQueue extends JXiFormsView
{
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