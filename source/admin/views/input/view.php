<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
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
		$link  	 =  "index.php?option=com_jxiforms&view=input&input_id=".$input->getId();
		
		$this->assign('input', $input);
		$this->assign('form',  $input->getModelform()->getForm($input));
		$this->assign('form_menu',  Rb_HelperJoomla::getExistingMenu($link, $cmp->id));
		
		$preview_link = JUri::root().$link."&tmpl=component";
		$this->assign('preview_link', JXiFormsHelperUtils::getModalLink($preview_link, 'COM_JXIFORMS_INPUT_HTML_PREVIEW', '380', '600', 'COM_JXIFORMS_INPUT_HTML_PREVIEW'));		
		
		$helpLink = JURI::base()."index.php?option=com_jxiforms&view=input&task=help&tmpl=component";
		$this->assign('help_link', JXiFormsHelperUtils::getModalLink($helpLink, '?', '410', '660', 'COM_JXIFORMS_FORM_POST_URL_HELP_DESC')); 
		
		
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
