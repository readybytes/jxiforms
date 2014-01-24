<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class UglyformsAdminViewInstall extends UglyformsAdminBaseViewInstall
{
	public function complete()
	{
		$app = UglyformsFactory::getApplication();
		$app->redirect("index.php?option=com_uglyforms&view=dashboard");
		
		return true;
	}
}