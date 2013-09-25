<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerInput extends JXiFormsController
{
	public function _save(array $data, $itemId=null)
	{

		$itemId		= ($itemId > 0 ) ? $itemId : '0';

		// Get data of Input(Form) to save.
		$formData 	= isset($data['input']) ? $data['input'] : array();

		$inputObj 	= JXiformsInput::getInstance($itemId);

		// Bind and Save data of form
		$result = $inputObj->bind($formData)->save();

		// Set proper Message and redirection URL 
		$msg	= Rb_Text::_('COM_JXIFORMS_INPUT_SAVE_ERROR');
		$url    = 'index.php?option=com_jxiforms&view=input&task=edit&id='.$inputObj->getId();
		$type	= 'Success';

		// Form is Saved or not
		if($result->getId())
		{
			$app = JFactory::getApplication();
			$msg = '';
			// Get All Enabled actions
			$xmlData	= JXiFormsHelperAction::getXml();
			
			// Actions attached on form
			$actions	= isset($data['action']) ? $data['action'] : array();

			// Save data of all actions attached with form
			foreach ($actions as $actionType => $dataToSave)
			{
				// For Proper mapping of actions on input
				$actions[$actionType]['action_params'] = isset($data['action'][$actionType]['action_params']) ? $data['action'][$actionType]['action_params'] : array();
				$actions[$actionType]['_action_inputs'] = $inputObj->getId();

				$actionId	= isset($dataToSave['action_id']) ? $dataToSave['action_id'] : '0';
				$actionObj  = JXiformsAction::getInstance($actionId, $actionType);
				if(!$actionObj->bind($actions[$actionType])->save()){
					// Enqueue message for every failure save
					$msg	= Rb_Text::_('COM_JXIFORMS_ACTION_SAVE_PROBLEM_MSG'.$actionType);
					$app->enqueueMessage($msg, 'error');
				}
				
				$msg = ucfirst($actionType).", ".$msg;
			}

			// Enqueue message for every successfull save
			$msg	= $msg.Rb_Text::_("COM_JXIFORMS_ACTION_SAVE_SUCCESSFULLY_MSG");
			$app->enqueueMessage($msg, 'notice');
		}
		// Redirect to edit screen
		$this->setRedirect($url, $msg, $type);
		return true;
	}
	
	public function edit()
	{
		$this->setTemplate('edit');
		return true;
	}

	function selectForm()
	{
		$this->setTemplate('selectform');
		return true;
	}
	
	public function createMenu()
	{
		return true;
	}

	public function addAction($actionType)
	{
		return true;
	}
	
	public function help(){
		return true;
	}
}