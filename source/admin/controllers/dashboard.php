<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerDashboard extends JXiFormsController
{
	//there is no model exists for dashboard
	function getModel($name = '', $prefix = '', $config = array())
	{
		return null;
	}
} 