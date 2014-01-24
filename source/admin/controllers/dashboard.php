<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminControllerDashboard extends UglyformsController
{
	//there is no model exists for dashboard
	function getModel($name = '', $prefix = '', $config = array())
	{
		return null;
	}
	
	public function enableActionPlugin()
	{
		//Enables the Plugin of Action		
		$pluginToEnable = JRequest::getVar('plugin');
		$pluginName		= JRequest::getVar('pluginName');
		Rb_HelperPlugin::changeState($pluginToEnable, "uglyforms");

		//Varifies the status of plugin
		$enabled		= UglyformsHelperJoomla::getPlugins('plugin', "uglyforms", true);
		($enabled[$pluginToEnable]) ? UglyformsFactory::getApplication()->enqueueMessage(sprintf(Rb_Text::_('COM_UGLYFORMS_DASHBOARD_ENABLE_PLUGIN_SUCCESSFULL_MESSAGE'), $pluginName),'success')
						: UglyformsFactory::getApplication()->enqueueMessage(sprintf(Rb_Text::_('COM_UGLYFORMS_DASHBOARD_ENABLE_PLUGIN_UNSUCCESSFULL_MESSAGE'), $pluginName),'notice');

		$this->setRedirect(Rb_Route::_('index.php?option=com_uglyforms&view=dashboard'));
		return false;
	}
} 