<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelInput extends JXiFormsModel
{
	public function delete($id=null)
	{
		if(!parent::delete($id))
		{
			$db = JXiFormsFactory::getDBO();
			Rb_Error::raiseError(500, $db->getErrorMsg());
		}

		// delete input from inputaction table
		$inputActionModel = JXiFormsFactory::getInstance('inputaction', 'model');
		$actionToRemove	 = $inputActionModel->getInputActions($id);

		//Removes All action Entries
		$actionModel		 = JXiFormsFactory::getInstance('action', 'model');
		$actionModel->deleteMany(array('`action_id`' => "(".implode(", ", $actionToRemove)).")", 'AND', 'IN');
		$inputActionModel->deleteMany(array('input_id' => $id));
	}
}

class JXiFormsModelformInput extends JXiFormsModelform { }
