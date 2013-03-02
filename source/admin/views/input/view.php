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
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$input   =  JXiformsInput::getInstance($itemId);
		
		//get the menus created for the current input and display it
		$cmp   	 =  JComponentHelper::getComponent('com_jxiforms');
		$link  	 =  "index.php?option=com_jxiforms&view=input&task=display&input_id=".$input->getId();
		
		$this->assign('input', $input);
		$this->assign('form',  $input->getModelform()->getForm($input));
		$this->assign('form_menu',  Rb_HelperJoomla::getExistingMenu($link, $cmp->id));
		
		$preview_link = JUri::root()."index.php?option=com_jxiforms&view=input&task=display&input_id=".$input->getId()."&tmpl=component";
		$this->assign('preview_link', JXiFormsHelperUtils::getModalLink($preview_link, 'COM_JXIFORMS_INPUT_HTML_PREVIEW', '380', '600', 'COM_JXIFORMS_INPUT_HTML_PREVIEW'));		
		return true;
	} 
}