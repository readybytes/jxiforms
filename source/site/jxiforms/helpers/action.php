<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsHelperAction extends JXiFormsHelper
{
	static function loadActions()
	{
		static $instances = null;

		//clean cache if required, required during testing
		if(JXiFormsFactory::cleanStaticCache()){
			$instances = null;
		}

		if($instances === null)
		{
			$queryFilters = array('published'=>1);
			$actions = JXiFormsFactory::getInstance('action', 'model')->loadRecords($queryFilters);

			$instances = array();
			foreach($actions as $action){
				$instance = JXiformsAction::getInstance( $action->action_id, $action->type, $action);
				if($instance === FALSE){
					continue;
				}
				
				$instances[$action->action_id] = $instance; 
			}
		}

		return $instances;
	}
	
	static function addActionsPath($path=null)
	{
		static $paths = array();

		if(($path != null) && !in_array($path, $paths)){
			$paths[]= $path;
		}

		return $paths;
	}
	
	static $_actions = array(); 
	
	/**
	 * Load Actions from various folders
	 * @return Array of Actions
	 */
	static function getActions()
	{
		//already loaded
		if(self::$_actions){
			return self::$_actions;
		}

		foreach(self::addActionsPath() as $path){
			$newActions = JFolder::folders($path);
			
			if(!is_array($newActions)){
				continue;
			}

			foreach($newActions as $action){
				$file = $path.'/'.$action.'/'.$action.'.php';
				if(JFile::exists($file)==true){
					
					Rb_HelperLoader::addAutoLoadFile($file, 'JXiFormsAction'.$action);
					
					self::$_actions[$action] = $action;
				}
			}
		}
		
		sort(self::$_actions);
		return self::$_actions;
	}
	
	static function getAvailableActions($type='')
	{
		//get Plugins classes names
		$actions = self::loadActions();

		$results = array();

		//trigger all actions if they are of mentioned type
		foreach($actions as $action)
		{
			if($action->hasType($type)){
				$results[$action->getId()] = $action;
			}
		}

		return $results;
	}
	
}