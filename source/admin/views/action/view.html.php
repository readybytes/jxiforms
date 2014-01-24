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

class UglyformsAdminViewAction extends UglyformsAdminBaseViewAction
{
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::addNew('selectAction');
		Rb_HelperToolbar::editList();
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
		Rb_HelperToolbar::divider();
		Rb_HelperToolbar::cancel();
	}

	//Overrided because no toolbar needed when task=selectAction.
	protected function _adminToolbar()
	{
		if($this->getTask() == 'selectAction'){
			return true;
		}
		else{
			return parent::_adminToolbar();
		}
	}
}