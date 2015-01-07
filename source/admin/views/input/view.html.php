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

class JXiFormsAdminViewInput extends JXiFormsAdminBaseViewInput
{
	protected function _adminGridToolbar()
	{
		JToolbarHelper::addNew('new');
		JToolbarHelper::divider();
		JToolbarHelper::publish('publish', 'JTOOLBAR_PUBLISH', true);
		JToolbarHelper::unpublish('unpublish','JTOOLBAR_UNPUBLISH', true);
		JToolbarHelper::divider();
		JToolbarHelper::deleteList(JText::_('COM_JXIFORMS_JS_ARE_YOU_SURE_TO_DELETE'));
	}
	
	protected function _adminEditToolbar()
	{
		JToolbarHelper::apply();
		JToolbarHelper::save();
		JToolbarHelper::save2new('savenew');
		JToolbarHelper::divider();
		JToolbarHelper::cancel();
	}
	
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
		$this->setTpl('help');
		return true;
	}
}