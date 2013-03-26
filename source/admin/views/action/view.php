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
	public function _displayGrid($records)
	{
		$enabledPluins[] = JXiFormsHelperAction::getXml();
		$this->assign('enable_plugins', $enabledPluins);
		parent::_displayGrid($records);
	}
	
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
		
		$xmlData  	   =  JXiFormsHelperAction::getXml();
		$help		   =  isset($xmlData[$action->getType()]) ? $xmlData[$action->getType()] : '';

		$this->assign('action', $action);
		$this->assign('form',   $action->getModelform()->getForm($action));
		$this->assign('help', $help);
		
		return true;
	}
	
	public	function selectAction()
	{
		$this->assign('actions', JXiFormsHelperAction::getXml());
		return true;
	}
}