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
	public function edit($tpl= null, $itemId = null, $actionType=null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
				
		if(!$itemId){
			$actionType =	JXiFormsFactory::getApplication()->input->get('type', $actionType);
			
			if(!$actionType){
				throw new Exception(Rb_Text::_("COM_JXIFORMS_EXCEPTION_NO_ACTION_TYPE_PROVIDED"));
			}
			
			$record = new stdClass();
			$record->type = $actionType;
		
			$action   =  JXiformsAction::getInstance($itemId, $record->type);
			$action->bind($record);
		}
		
		else {
			$action   =  JXiformsAction::getInstance($itemId);
		}
		
		$this->assign('action', $action);
		$this->assign('form',   $action->getModelform()->getForm($action));
		
		return true;
	}
	
	public	function selectAction()
	{
		$actions = JXiFormsHelperAction::getActions();
		$this->assign('actions', $actions);
		return true;
	}
}