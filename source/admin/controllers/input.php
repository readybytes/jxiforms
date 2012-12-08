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
		// when there is no action selected in actions param then _input_actions 
		// does not get posted which results in incorrect data to bind with instance 
		$data['_input_actions']  = isset($data['_input_actions']) ?  $data['_input_actions'] : array();
		return parent::_save($data, $itemId);
	}
} 