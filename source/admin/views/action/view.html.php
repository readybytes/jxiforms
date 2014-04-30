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

class UglyformsAdminViewAction extends UglyformsAdminBaseViewAction
{
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::addNew('selectAction');
		Rb_HelperToolbar::editList();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::publish();
		Rb_HelperToolbar::unpublish();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		Rb_HelperToolbar::apply();
		Rb_HelperToolbar::save();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::cancel();
	}

	//Overrided because no toolbar needed when task=selectAction.
	protected function _adminToolbar()
	{
		if($this->getTask() == 'selectAction'){
			return true;
		}
		else{
			return parent::_adminToolbar();
		}
	}
	
	public function _adminSubmenu()
	{
		$view = strtolower(UglyformsFactory::getApplication()->input->get('view', ''));
		$task = $this->getTask();
		
		if($task == 'selectAction' || $task == 'display'){
			foreach(self::$_submenus as $menu){
				Rb_HelperToolbar::addSubMenu($menu, $view, $this->_component->getNameCom());
			}
		}
		
		return $this;
	}
	
	public function _displayGrid($records)
	{
		$enabledPlugins = array();
		$enabledPlugins = UglyformsHelperAction::getXml();
		$this->assign('enable_plugins', $enabledPlugins);
		parent::_displayGrid($records);
	}
	
	public function edit($tpl= null, $itemId = null, $actionType=null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
				
		if(!$itemId){
			$actionType =	UglyformsFactory::getApplication()->input->get('type', $actionType);
			
			if(!$actionType){
				throw new Exception(Rb_Text::_("COM_UGLYFORMS_EXCEPTION_NO_ACTION_TYPE_PROVIDED"));
			}
			
			$record = new stdClass();
			$record->type = $actionType;
		
			$action   =  UglyformsAction::getInstance($itemId, $record->type);
			$action->bind($record);
		}
		
		else {
			$action   =  UglyformsAction::getInstance($itemId);
		}
		
		$xmlData  	   =  UglyformsHelperAction::getXml();
		$help		   =  isset($xmlData[$action->getType()]) ? $xmlData[$action->getType()] : '';

		$this->assign('action', $action);
		$this->assign('form',   $action->getModelform()->getForm($action));
		$this->assign('help', $help);
		$this->assign('show_editor', $action->showEditor());
		$this->assign('show_approval_setting', $action->approvalApplicable());
		
		return true;
	}
	
	public function selectAction()
	{
		$this->assign('actions', UglyformsHelperAction::getXml());
		return true;
	}
}