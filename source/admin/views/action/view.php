<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewAction extends JXiFormsView
{ 
	public function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$action   =  JXiformsAction::getInstance($itemId);
		
		$this->assign('action', $action);
		$this->assign('form',  $action->getModelform()->getForm($action));
		
		return true;
	}
}