<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerInstall extends JXiFormsController
{
	function getModel($name = '', $prefix = '', $config = array())
	{
		return null;
	}
	
	public function complete()
	{
		return true;	
	}
}