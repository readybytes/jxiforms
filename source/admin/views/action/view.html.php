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

class JXiFormsAdminViewAction extends JXiFormsAdminBaseViewAction
{
	protected function _adminGridToolbar()
	{
		JToolbarHelper::addNew('selectAction');
		JToolbarHelper::editList();
		JToolbarHelper::divider();
		JToolbarHelper::publish('publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('unpublish','JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::divider();
		JToolbarHelper::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		JToolbarHelper::apply();
		JToolbarHelper::save();
		JToolbarHelper::divider();
		JToolbarHelper::cancel();
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
	
	public function _displayGrid($records)
	{
		$enabledPlugins = array();
		$enabledPlugins = JXiFormsHelperAction::getXml();
		$this->assign('enable_plugins', $enabledPlugins);
		parent::_displayGrid($records);
		return true;
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