<?php

/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class  plgUglyformsJoomlaacl extends UglyformsPlugin
{
	protected $_location	= __FILE__;
	
	public function onUglyformsControllerBeforeExecute($controller, $task, $name)
	{
		if ($name != 'input'){
			return true;
		}
		
		//input object
		$input = UglyformsInput::getInstance($controller->_getId());
		
		//logged in user
		$user = UglyformsFactory::getUser();
		
		$actions = UglyformsHelperAction::getApplicableActions('joomlaacl', $input, true);

		foreach ($actions as $action){
			$result = $action->authorise($input, $user);

			if ($result == false){
				$app = UglyformsFactory::getApplication();
				$app->enqueueMessage(Rb_Text::_('COM_UGLYFORMS_ERROR_NOT_AUTHORIZED'), 'error');
				$app->redirect('index.php');
				return false;
			}
		}
		
		return true;
	}
}
