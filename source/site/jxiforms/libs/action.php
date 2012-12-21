<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

/**
 * Base class for all jxiforms-actions who have multiple instances
 * @author bhavya
 *
 */
class JXiformsAction extends JXiFormsLib
{ 
	protected   $action_id  	   =   0;
	protected 	$title    	   	   =   '';
	protected   $type			   =   '';
	protected 	$description   	   =   '';
	
	protected   $ordering		   =    0;
	protected 	$published	   	   =	1;
	protected   $for_all_inputs	   =    0;
	
	protected 	$core_params	   =   null;
	protected 	$action_params	   =   null;
	protected   $data			   =   '';
	
	protected 	$_action_inputs  =   null;
	
	/**
	 * Gets the instance of JXiFormsAction with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of action entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object JXiformsAction  Instance of JXiformsAction
	 */
	public static function getInstance($id = 0,  $type = null,  $bindData = null)
	{
		static $instance=array();

		//clean cache if required
		if(JXiFormsFactory::cleanStaticCache()){
			$instance=array();
		}
		
		$name = 'Action';
		//generate class name
		$className	= 'JXiForms'.$name;

		//try to calculate type of app from ID if given
		if($id){
			if(!empty($bindData)){
				$item = is_array($bindData) ? (object) $bindData : $bindData;
			}else{
				$item =  JXiFormsFactory::getInstance('action', 'model')->loadRecords(array('id'=>$id));
				$item = array_shift($item);
			}

				$type = $item->type;
		}

			Rb_Error::assert($type!==null, Rb_Text::_('PLG_SYSTEM_RBSL_ERROR_INVALID_TYPE_OF_APPLICATION'));

			//IMP autoload actions
			JXiFormsHelperAction::getActions();
			$className	.= $type;

		// in classname does not exists then return false
		if(class_exists($className, true) === FALSE){
			return false;
		}	
		
		//bind data with instance even when object is not saved
		if(!$id){
			$class_instance = new $className();
			return $bindData ? $class_instance->bind($item)
							 : $class_instance;
		}

		//if already there is an object and check for static cache clean up
		if(isset($instance[$name][$id]) && $instance[$name][$id]->getId()==$id)
			return $instance[$name][$id];

		//create new object, class must be autoloaded
		$instance[$name][$id] = new $className();

		//if bind data exist then bind with it, else load new data
		return  $bindData 	? $instance[$name][$id]->bind($item)
					: $instance[$name][$id]->load($id);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object JXiformsAction Instance of JXiformsAction
	 */
	function reset()
	{
		$this->action_id 		= 0;
		$this->title			= '';
		$this->type				= '';
		$this->description  	= '';
		$this->published		= 1;
		$this->for_all_inputs	= 0;
		$this->ordering		 	= 0;
		$this->core_params		= new Rb_Registry();
		$this->action_params	= new Rb_Registry();
		$this->data				= '';
		$this->_action_inputs	= array();

		return $this;
	}
	
	/**
	 * Bind the inputs(forms) with the action(app) data
	 * @return object JXiformsAction Instance of type JXiformsAction
	 */
	public function afterBind($id = 0, $data)
	{ 
		if($id) {
			$this->_action_inputs = JXiFormsFactory::getInstance('inputaction', 'model')
										->getActionInputs($id);
		}
		
		if(isset($data['_action_inputs'])){
			$this->_action_inputs = is_array($data['_action_inputs']) ? $data['_action_inputs'] : array($data['_action_inputs']);
		}
									
		return $this;
	}
	
	/**
	 * Save the action and its association with inputs in inputaction table
	 * 
	 * @return object JXiformsAction  Instance of JXiformsAction
	 */
	public function save()
	{		
		if(!parent::save()){
			return false;
		}
		
		return $this->_saveActionInputs();
	}
	
	/**
	 * Save action association with the input
	 * @return object JXiformsAction  Instance of type JXiformsAction
	 */
	private function _saveActionInputs()
	{
		// delete all the existing values of current input_id
		$model = JXiFormsFactory::getInstance('inputaction', 'model');
		$model->deleteMany(array('action_id' => $this->getId()));

		// insert new values into inputaction for current input_id
		$data['action_id'] = $this->getId();
		if(is_array($this->_action_inputs)){
			foreach($this->_action_inputs as $input){
				$data['input_id'] = $input;
				$model->save($data);
			}
		}

		return $this;
	} 
	
	/**
	 * Check the action Type
	 * @return boolean  True when action is of mentioned type else False
	 */
	public function hasType($type='')
	{
		if($type==='')
			return true;

		$type = JString::ucfirst(JString::strtolower($type));
		
		return is_a($this, 'JXiFormsAction'.$type);
	}
	
	public function getId()
	{
		Rb_Error::assert($this);
		return $this->action_id;
	}
	
	public function getName()
	{
		if(isset($this->type)==false || empty($this->type))
		{
			$r = null;
			if (!preg_match('/Action(.*)/i', get_class($this), $r)) {
				JError::raiseError (500, "JXiForms: Can't get or parse class name.");
			}
			$this->type = strtolower( $r[1] );
		}

		return $this->type;
	}
	
	public function load($id = 0)
	{
		if(!$id) return $this;

		$actions = JXiFormsFactory::getInstance('action', 'model')
							->loadRecords(array('id' => $id));
		$this->bind(array_shift($actions));
		return $this;
	}
	
	public function getModelform()
	{
		if(isset($this->_modelform)){
			return $this->_modelform;
		}
		
		// setup modelform
		$this->_modelform = Rb_Factory::getInstance('action', 'Modelform' , $this->_component->getPrefixClass());
		
		// set model form to pick data from this object
		$this->_modelform->setLibData($this);
		
		return $this->_modelform ;
	}
	
	public function getModel()
	{
		return Rb_Factory::getInstance('action', 'Model', $this->_component->getPrefixClass());
	}
	
	public function getLocation()
    {
    	return dirname($this->_location);
    }
    
    public function filterActionParams(array $data)
    {
    	if(!isset($data['action_params'])){
    		$data['action_params'] = array();
    	}
    	return json_encode($data['action_params']);
    }
    
	public function filterCoreParams(array $data)
    {
    	if(!isset($data['core_params'])){
    		$data['core_params'] = array();
    	}
    	return json_encode($data['core_params']);
    }
	
    public function isApplicable($refObject=null, $eventName='')
    {
    	//return when refObject is not set
		if(($refObject === null) || !($refObject instanceof JXiformsInput)){
			return false;
		}

		//if applicable to all is false then check input vs action
		if($this->forAllInputs() == false){
			$ret = array_intersect($this->getInputs(), $refObject->getInputs());
			if(count($ret) <= 0 ){
				return false;
			}
		}
		// finally check if plugin want trigger for this or not
		return (boolean) $this->_isApplicable($refObject, $eventName);
    }
    
    /**
     * Check whether action is applicable to all the inputs or to any specific input
     * @return boolean  True if action is applicable to all the inputs else False
     */
    public function forAllInputs()
    {
    	return (boolean) $this->for_all_inputs;
    }
    
    public function getInputs()
    {
    	return $this->_action_inputs;
    }
    
	public function _isApplicable($refObject, $eventName='')
	{
		return true;
	}
	
	public function getActionParams()
	{
		return $this->action_params;
	}
	
	public function setId($id)
	{
		Rb_Error::assert($this);
		$varName = 'action_id';
		$this->$varName = $id;
		return $this;
	}
	
	public function getActionParam($key, $default=null)
	{
		Rb_Error::assert($this);
		return $this->action_params->get($key,$default);
	}
	
	public function setActionParam($key, $value)
	{
		Rb_Error::assert($this);
		
		$this->action_params->set($key,$value);
		return $this;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function showDataEditor()
	{
		return true;
	}
	
}