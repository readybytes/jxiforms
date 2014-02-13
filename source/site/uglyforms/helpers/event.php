<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsHelperEvent extends UglyformsHelper
{
	public static function trigger($eventName, $args, $type)
	{
		//TODO : add option if only plugin or action needs to trigger
		$results = array();
		
		//TRIGGER plugin
		$plugins = UglyformsHelperJoomla::getPlugins('uglyforms', 1);
		Rb_HelperPlugin::loadPlugins('uglyforms');
				
		foreach ($plugins as $key=>$plugin){
			$plg_inst = Rb_HelperPlugin::getPluginInstance('uglyforms', $key);
			
			if(method_exists($plg_inst, $eventName)){
				$results[] = call_user_func_array(array($plg_inst,$eventName), $args);
			}
		}
		
		
		
		//TRIGGER action
		$actions = UglyformsHelperAction::getApplicableActions('', $args[0]);
		
		foreach ($actions as $action){
			if (method_exists($action, $eventName)){
				//$results[] = call_user_func_array(array($action, $eventName), $args);
				$results[] = $action->$eventName($args[0], $args[1], $args[2]);
			}
		}
		
		return $results;
	}
}