<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsAdminViewQueue extends JXiFormsAdminBaseViewQueue
{
	protected function _adminGridToolbar()
	{
		Rb_HelperToolbar::deleteList();
	}
}