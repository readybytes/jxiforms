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
	public static function get($id = 0)
	{
		static $actions = null;
		if(($id !== 0 && !isset($actions[$id])) || $actions == null){
			$actions = JXiFormsFactory::getInstance('action', 'model')->loadRecords();
		}
		
		if($id === 0){
			return $actions;
		}
		
		if(isset($actions[$id])){
			return $actions[$id];
		}
		
		return false;
	}
	
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
	
	public static function addAction($type)
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
	
	static $xmlData = null;
	static public function getXml()
	{
		$actions = self::getActions();
		
		if(self::$xmlData === null){
			
			foreach($actions as $action){
				$appInstance = JXiformsAction::getInstance( null, $action);
				 
				if($appInstance == false){
					continue;
				}
				
				$xml = $appInstance->getLocation() .'/'. $appInstance->getName() . '.xml';

				if (file_exists($xml)) {
					$xmlContent = simplexml_load_file($xml);
				}
				else {
					$xmlContent = null;
				}

				self::$xmlData[$appInstance->getName()]['location'] = $appInstance->getLocation();
				foreach ($xmlContent as $element=> $value){
					self::$xmlData[$appInstance->getName()][$element] = (string) $value;
				}
			}
		}
		
		return self::$xmlData;
	}
	
	static function getApplicableActions($type='', $refObject=null)
	{
		$actions = self::loadActions();
		$results = array();

		foreach($actions as $action)
		{
			if($action->hasType($type) && $action->isApplicable($refObject)){
				$results[$action->getId()] = $action;
			}
		}

		return $results;
	}
}