<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminControllerInstall extends UglyformsController
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