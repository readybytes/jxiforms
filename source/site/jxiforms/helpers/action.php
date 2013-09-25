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
	
	// Prepares XML in desired way : data[action][action_type][all_fields_which_will_be_redered_through_template]
	static public function getProperXML($actionType, $itemId)
	{
		$actionType =	isset($actionType) ? $actionType : JXiFormsFactory::getApplication()->input->get('type', $actionType);
		
		// Rise Exception : no action type provided
		if(!$actionType){
			throw new Exception(Rb_Text::_("COM_JXIFORMS_EXCEPTION_NO_ACTION_TYPE_PROVIDED"));
		}
		
		// Assign action type
		$record = new stdClass();
		$record->type = $actionType;
		$itemId  =  ($itemId > 0) ? $itemId : '0';
		
		// Bind type with action object
		$action   =  JXiformsAction::getInstance($itemId, $record->type);
		$action->bind($record);
		
		// Get XML Form
		$actionForm =  $action->getModelform()->getForm($action);

		//This will create a new fields of action Type.
		$actionTypeFields = simplexml_load_string('<fields></fields>');
		$actionTypeFields->addAttribute("name", $actionType);
		$actionTypeFields = array($actionTypeFields);		
		
		//Adds action type Fields in Action Form xml heirarchy.
		$actionForm->setFields($actionTypeFields, 'action');

		//Path of action.xml
		$xmlPath = JXIFORMS_PATH_CORE_FORMS.'/action.xml';
		
		//Loads action.xml's data
		$data = simplexml_load_file($xmlPath);
		
		//Gets all feild from action.xml from which specific will bw added to Action Form
		$paramField = $data->fields;
		$paramField = $paramField->fieldset;
		
		// Required : because these all are core fields and an action must have to contains these 
		$reqField 	= array('action_id' => 'action_id',
							'type'      => 'type',
							'published' => 'published',
							'data'		=> 'data');
		
		//Adds all required field in Action Form xml heirarchy
		foreach($paramField->field as $fieldOfXML){
			//Gets the Name of SimpleXMLElement.
			$fieldName = strval($fieldOfXML->attributes()->name);
			
			//If Required then Add in Action Form xml heirarchy.
			if(array_key_exists($fieldName, $reqField)){
				$actionForm->setField($fieldOfXML, "action.$actionType");
			}
		}
		
		//Adds core_params fields in Action Form xml heirarchy
		$coreParamsFields = simplexml_load_string('<fields></fields>');
		$coreParamsFields->addAttribute("name", 'core_params');
		$actionForm->setField($coreParamsFields, "action.$actionType");
		
		//Adds core_param's field in Action Form xml heirarchy
		$coreParamsFields = $paramField->fields;
		foreach($coreParamsFields->fieldset as $fieldOfXML){
			$actionForm->setField($fieldOfXML, "action.$actionType.core_params");
		}
		
		//For Loading Xml of Action
		$pathForAction    = $action->getLocation();
		$pathForActionXML = explode(".php", $pathForAction);
		$pathForActionXML = $pathForActionXML[0]."/".$action->getType().".xml";
		$actionXML = file_exists($pathForActionXML) ? simplexml_load_file($pathForActionXML) : "";
		
		//Adds Action_params in Xml Heirarchy of Form Xml
		if( $actionXML instanceof SimpleXMLElement){
			$actionParamsFieldset = $actionXML->fields;
			$actionForm->setField($actionParamsFieldset, "action.$actionType");
		}
		
		//Bind Object of Action with Form
		$actionForm->bind(array('action' => array("$actionType" => $action->toArray())));

		//Gets Array of All XML Elements under Action Type
		$actionFields = $actionForm->getGroup("action.$actionType", true);
		
		//Creates array of XML Elements
		$action_fields = array();
		foreach ($actionFields as $field){
			$action_fields[$field->fieldname] = $field;
		}
		
		//Adds Action_Params in above created Array
		$parameters = $actionForm->getGroup("action.$actionType.action_params", true);
		foreach ($parameters as $field){
			$action_fields['action_params'][$field->fieldname] = $field;
		}

		//Assigns array to be used in Template 
		return $action_fields;
	}
}