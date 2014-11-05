<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerDashboard extends JXiFormsController
{
	//there is no model exists for dashboard
	function getModel($name = '', $prefix = '', $config = array())
	{
		return null;
	}
	
	public function enableActionPlugin()
	{
		$input = JXiFormsFactory::getApplication()->input;
		
		//Enables the Plugin of Action
		$pluginToEnable = $input->get('plugin');
		$pluginName		= $input->get('pluginName');
		
		Rb_HelperJoomla::changePluginState($pluginToEnable, "jxiforms");

		//Varifies the status of plugin
		$enabled		= JXiFormsHelperJoomla::getPlugins('plugin', "jxiforms", true);
		($enabled[$pluginToEnable]) ? JXiFormsFactory::getApplication()->enqueueMessage(sprintf(JText::_('COM_JXIFORMS_DASHBOARD_ENABLE_PLUGIN_SUCCESSFULL_MESSAGE'), $pluginName),'message')
						: JXiFormsFactory::getApplication()->enqueueMessage(sprintf(JText::_('COM_JXIFORMS_DASHBOARD_ENABLE_PLUGIN_UNSUCCESSFULL_MESSAGE'), $pluginName),'notice');

		$this->setRedirect(Rb_Route::_('index.php?option=com_jxiforms&view=dashboard'));
		return false;
	}
} 