<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewInput extends JXiFormsView
{
	function edit($tpl= null, $itemId = null)
	{
		$xmlData = array();
		$actionData = array();
		$actionObject = array();
		
		// Prepare Form Related data : START
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$input   =  JXiformsInput::getInstance($itemId);
		
		//get the menus created for the current input and display it
		$cmp   	 =  JComponentHelper::getComponent('com_jxiforms');
		$link  	 =  "index.php?option=com_jxiforms&view=input&input_id=".$input->getId();

		// Get input form and bind data
		$inputForm =  $input->getModelform()->getForm($input);
		$inputForm->bind(array('input' => $input->toArray()));
		
		$this->assign('input', $input);
		$this->assign('inputForm',  $inputForm);
		$this->assign('form_menu',  Rb_HelperJoomla::getExistingMenu($link, $cmp->id));
		
		$helpLink = JURI::base()."index.php?option=com_jxiforms&view=input&task=help&tmpl=component";
		$this->assign('help_link', JXiFormsHelperUtils::getModalLink($helpLink, '?', '410', '660', 'COM_JXIFORMS_FORM_POST_URL_HELP_DESC'));


		
		
		// Get and arrange input form fields
		$inputFields = array();
		$inputFields = $inputForm->getFieldset('input');
		foreach ($inputFields as $field){
			$input_fields[$field->fieldname] = $field;
		}
		
		$this->assign('input_fields', $input_fields);
		// Prepare Form Related data : END
				
		// Get all Enabled Action plugins
		$enableActions = JXiFormsHelperAction::getXml();
		
		// No item Id then get all data of form
		if(!isset($itemId))
		{
			// Get Form Type
			$formType = JXiFormsFactory::getApplication()->input->get('formtype');
			
			// Make sure atleast one action plugin is installed or enabled
			if(is_array($enableActions) && array_key_exists($formType, $enableActions))
			{
				$plugin		= $enableActions["$formType"];
				
				// Assgin html code of plugin xml
				$this->assign('code', $plugin['code']);
				
				// Assign type of form
				$this->assign('type', $formType);
				
				// Get Action instance of Form Type
				$actionObject[$formType]	= JXiformsAction::getInstance(0, $formType);
				
				// Add XML on action's object and assign data to template
				$actionData["$formType"]	= JXiFormsHelperAction::getProperXML($formType, $itemId);
				
				// Assign XML contents of action and above calculated data.
				$xmlData["$formType"]			= isset($enableActions["$formType"]) ? $enableActions["$formType"] : '';
				$this->assign('xmlData', $xmlData);
				$this->assign('actions', $actionData);
				$this->assign('action', $actionObject);
				return true;
			}
		}
		
		// Get all actions attached.
		$actionIds	= $input->getActions();
		
		// Process all actions one-by-one
		foreach($actionIds as $actionId)
		{
			// Get action's object
			$action					= JXiformsAction::getInstance($actionId);
			$actionType 			= $action->getType();
			// Collect all action's objects
			$actionObject[$actionType]	= $action;
			
			// Collect all actions fields, field on type action
			$actionData[$actionType] 	= JXiFormsHelperAction::getProperXML($actionType, $action->getId());
			
			// Collect XML data of all actions
			$xmlData["$actionType"]		= isset($enableActions[$actionType]) ? $enableActions[$actionType] : '';
		}
		
		
		// Assign data to template
		$this->assign('type', $actionType);
		$this->assign('action', $actionObject);	
		$this->assign('xmlData', $xmlData);
		$this->assign('actions', $actionData);
		$this->assign('code', $enableActions["$actionType"]['code']);
		
		return true;
	}

	public	function selectform()
	{
		$this->assign('enablePlugins', JXiFormsHelperAction::getXml());
		return true;
	}
	
	function help()
	{
		$helpImage = JURI::base()."components/com_jxiforms/templates/default/_media/icons/post_url_help.png";
		$this->assign('help_image', $helpImage);
		$this->setTpl('help');
		return true;
	}
}
