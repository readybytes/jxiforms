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
	public function display($tpl=null)
	{
		//For Published and Unpublished plugins icons on dashboard.
		$this->assign('enablePlugins', JXiFormsHelperAction::getXml());
		$disabledPlugins = JXiFormsHelperJoomla::getPlugins('plugin','jxiforms',false);

		foreach($disabledPlugins as $plugin)
		{
				$pluginPath = JXIFORMS_PATH_PLUGIN."/".$plugin->element."/action";
				
				//plugin does not necessarily contain action like in autodelete plugin
                if (!is_dir($pluginPath)){
                    unset($disabledPlugins[$plugin->element]);
                    continue;
                }
                
				$actions	 	  = JFolder::folders($pluginPath);

				unset($disabledPlugins[$plugin->element]);
				foreach ($actions as $action)
				{
					$actionPath = $pluginPath."/".$action;
					$xml = $actionPath."/".$action.".xml";
					if(file_exists($xml))
					{
						$xmlContent = simplexml_load_file($xml);
					}
					
					$disabledPlugins[$action] 		   = new stdClass();
					$disabledPlugins[$action]->element = $plugin->element;
					$disabledPlugins[$action]->name    = $xmlContent->name;
					$disabledPlugins[$action]->icon    = file_exists($actionPath."/".$xmlContent->icon) ? $actionPath."/".$xmlContent->icon : JXIFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png';
					
				}
		}
		//For Pop-up of How it Works
		$this->assign('howItWorks', JXiFormsHelperUtils::getModalLink('http://pub.joomlaxi.com/broadcast/joomlaxi-form/how-it-works/info.html','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS','600','970','COM_JXIFORMS_DASHBOARD_TEXT_HOW_IT_WORKS_TOOL_TIP'));
		$this->assign('disablePlugins',$disabledPlugins);
		return true;
	}
	
	public function _basicFormSetup($task)
	{
		return true;
	}
}