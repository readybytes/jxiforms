<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class UglyformsAdminViewInput extends UglyformsAdminBaseViewInput
{
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::addNew('new');
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::publish();
		Rb_HelperToolbar::unpublish();
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::deleteList();
	}
	
	protected function _adminEditToolbar()
	{
		Rb_HelperToolbar::apply();
		Rb_HelperToolbar::save();
		Rb_HelperToolbar::save2new('savenew');
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::cancel();
	}
	
	function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		$input   =  UglyformsInput::getInstance($itemId);
		
		//get the menus created for the current input and display it
		$cmp   	 =  JComponentHelper::getComponent('com_uglyforms');
		$link  	 =  "index.php?option=com_uglyforms&view=input&input_id=".$input->getId();
		
		$this->assign('input', $input);
		$this->assign('form',  $input->getModelform()->getForm($input));
		$this->assign('form_menu',  Rb_HelperJoomla::getExistingMenu($link, $cmp->id));
		$this->assign('input_html', $input->getRecentInputhtml());
		
		$preview_link = JUri::root().$link."&tmpl=component";
		$this->assign('preview_link', UglyformsHelperUtils::getModalLink($preview_link, 'COM_UGLYFORMS_INPUT_HTML_PREVIEW', '380', '600', 'COM_UGLYFORMS_INPUT_HTML_PREVIEW'));		
		
		return true;
	}
}