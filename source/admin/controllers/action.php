<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerAction extends JXiFormsController
{
	public function _save(array $data, $itemId=null)
	{
		Rb_Error::assert(isset($data['type']), Rb_Text::_('COM_JXIFORMS_ERROR_TYPE_IS_NOT_DEFINED_FOR_ACTION'));
		$action = JXiformsAction::getInstance($itemId, $data['type']);

		$data['core_params'] 	= $action->collectCoreParams($data);
		$data['action_params']  = $action->collectActionParams($data);

		return parent::_save($data, $itemId, $data['type']);
	}
	
	function selectAction()
	{
		$this->setTemplate('selectaction');
		return true;
	}
} 