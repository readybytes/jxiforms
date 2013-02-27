<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewDashboard extends JXiFormsView
{
	public function display()
	{
		//For Published and Unpublished plugins icons on dashboard.
		$this->assign('enablePlugins',  JXiFormsHelperAction::getXml());
		$this->assign('disablePlugins', JXiFormsHelperJoomla::getPlugins('plugin','jxiforms',false));
		
		//For Pop-up of How it Works
		$this->assign('howItWorks', JXiFormsHelperUtils::getModalLink('http://pub.joomlaxi.com/broadcast/xiform/how-it-works/tab.html','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS','552','960','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS_TOOL_TIP'));
		return true;
	}
	
	public function _basicFormSetup($task)
	{
		return true;
	}
}