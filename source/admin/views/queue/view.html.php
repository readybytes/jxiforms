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
		Rb_HelperToolbar::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		Rb_HelperToolbar::cancel();
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
}