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
	
	public function createMenu()
	{
		$input_id 	= $this->getModel()->getId();
		$data  		= JXiFormsFactory::getApplication()->input->post->get('jxiforms_form', array(), 'array');
		$advance 	= $data['advance'];
		
		$cmp   	=  JComponentHelper::getComponent('com_jxiforms');
		$link  	=  "index.php?option=com_jxiforms&view=input&input_id=".$input_id;
		$result =  Rb_HelperJoomla::addMenu($advance['menu_title'], $advance['menu_alias'], $link, $advance['menu_location'], $cmp->id);

		$url     = 'index.php?option=com_jxiforms&view=input&task=edit&input_id='.$input_id;
		$message = Rb_Text::_('COM_JXIFORMS_INPUT_CREATE_MENU_SUCCESSFULLY');
		$type	 = 'message';
		
		if($result === false){
			$message  = Rb_Text::_('COM_JXIFORMS_ERROR_INPUT_CREATE_MENU');
			$type	  = 'error';		
		}
		
		$this->setRedirect($url, $message, $type);
		return false;
	}
	
	public function help(){
		return true;
	}
}