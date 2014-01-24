<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminBaseViewInstall extends UglyformsView
{
	public function display()
	{
	$this->assign('howItWorks', UglyformsHelperUtils::getModalLink('http://pub.joomlaxi.com/broadcast/joomlaxi-form/how-it-works/info.html','COM_UGLYFORMS_DASHBOARD_TEXT_HOW_IT_WORKS','600','970','COM_UGLYFORMS_DASHBOARD_TEXT_HOW_IT_WORKS_TOOL_TIP'));
		return true;
	}
	public function _basicFormSetup($task)
	{
		return true;
	}
}