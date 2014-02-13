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
			
			//if any plugin returns false as a result of validation check
			//then do not proceed further with other plugins and mark data in log  
			if (in_array(false, $results)){
				return $results;
			}
		}
		
		
		
		//TRIGGER action
		$actions = UglyformsHelperAction::getApplicableActions('', $args[0]);
		
		foreach ($actions as $action){
			if (method_exists($action, $eventName)){
				//$results[] = call_user_func_array(array($action, $eventName), $args);
				$results[] = $action->$eventName($args[0], $args[1], $args[2]);
			}
			
			//if any action returns false as a result of validation check
			//then do not proceed further with other actions and mark data in log  
			if (in_array(false, $results)){
				return $results;
			}
		}
		
		return $results;
	}
}