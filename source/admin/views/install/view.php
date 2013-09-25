<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewInstall extends JXiFormsView
{
	public function display()
	{
	$this->assign('howItWorks', JXiFormsHelperUtils::getModalLink('http://pub.joomlaxi.com/broadcast/joomlaxi-form/how-it-works/info.html','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS','600','970','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS_TOOL_TIP'));
		return true;
	}
	public function _basicFormSetup($task)
	{
		return true;
	}
}