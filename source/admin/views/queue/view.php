<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminBaseViewQueue extends UglyformsView
{
	function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$queue   =  UglyformsQueue::getInstance($itemId);
		
		$relevant_data = UglyformsHelperQueue::fetchData($queue->getToken(), true);		
		
		$this->assign('queue', 				$queue);
		$this->assign('input', 				UglyformsHelperInput::get($queue->getInput()));
		$this->assign('action',  			UglyformsHelperAction::get($queue->getAction()));
		$this->assign('status', 			UglyformsQueue::getStatusList());
		$this->assign('form',  				$queue->getModelform()->getForm($queue));
		$this->assign('queue_data',  		$relevant_data['data']);
		$this->assign('queue_attachments',  $relevant_data['attachments']);
				
		return true;
	} 
}