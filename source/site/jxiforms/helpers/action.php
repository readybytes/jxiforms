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

		$type = 'jxiforms';
		Rb_HelperPlugin::loadPlugins($type);
		
		sort(self::$_actions);
		return self::$_actions;
	}
	
	public function addAction($type)
	{
		self::$_actions[$type] = $type;
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