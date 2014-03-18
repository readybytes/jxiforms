<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

/**
 * Base class for all uglyforms-actions who have multiple instances
 * @author bhavya
 *
 */
class UglyformsAction extends UglyformsLib
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
	
	public      $show_editor 		= false;
	
	/**
	 * Gets the instance of UglyformsAction with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of action entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object UglyformsAction  Instance of UglyformsAction
	 */
	public static function getInstance($id = 0,  $type = null,  $bindData = null)
	{
		static $instance=array();

		//clean cache if required
		if(UglyformsFactory::cleanStaticCache()){
			$instance=array();
		}
		
		$name = 'Action';
		//generate class name
		$className	= 'Uglyforms'.$name;

		//try to calculate type of app from ID if given
		if($id){
			if(!empty($bindData)){
				$item = is_array($bindData) ? (object) $bindData : $bindData;
			}else{
				$item =  UglyformsFactory::getInstance('action', 'model')->loadRecords(array('id'=>$id));
				$item = array_shift($item);
			}

				$type = $item->type;
		}

			Rb_Error::assert($type!==null, Rb_Text::_('PLG_SYSTEM_RBSL_ERROR_INVALID_TYPE_OF_APPLICATION'));

			//IMP autoload actions
			UglyformsHelperAction::getActions();
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
	 * @return  Object UglyformsAction Instance of UglyformsAction
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
	 * @return object UglyformsAction Instance of type UglyformsAction
	 */
	public function afterBind($id = 0, $data)
	{ 
		if($id) {
			$this->_action_inputs = UglyformsFactory::getInstance('inputaction', 'model')
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
	 * @return object UglyformsAction  Instance of UglyformsAction
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
	 * @return object UglyformsAction  Instance of type UglyformsAction
	 */
	private function _saveActionInputs()
	{
		// delete all the existing values of current input_id
		$model = UglyformsFactory::getInstance('inputaction', 'model');
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
	 * Check the action purpose
	 * Action Purpose basically denotes the work that action is supposed to do
	 * for eg. data-validation, data-processing 
	 * Purpose is identified by the interface an action implements
	 * @return boolean  True when action is of mentioned purpose else False
	 */
	public function hasPurpose($purpose='')
	{
		if($purpose==='')
			return true;

		$purpose = JString::ucfirst(JString::strtolower($purpose));
		
		return is_a($this, 'UglyformsInterface'.$purpose);
	}
	
	public function hasType($type='')
	{
		if($type==='')
			return true;

		$type = JString::ucfirst(JString::strtolower($type));
		
		return is_a($this, 'UglyformsAction'.$type);
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
				JError::raiseError (500, "Uglyforms: Can't get or parse class name.");
			}
			$this->type = strtolower( $r[1] );
		}

		return $this->type;
	}
	
	public function load($id = 0)
	{
		if(!$id) return $this;

		$actions = UglyformsFactory::getInstance('action', 'model')
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
		if(($refObject === null) || !($refObject instanceof UglyformsInput)){
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
	
	public function getType()
    {
    	return $this->type;
    }
    
	public function getParam($key, $default=null)
	{
		return $this->core_params->get($key,$default);
	}
	
	/**
	 * Render plugins template
	 */
	protected function _render($tpl, $args=null, $layout = null)
	{
		return $this->_loadTemplate($tpl, $args, $layout);
	}


	protected function _loadTemplate($tpl = null, $args = null, $layout=null)
	{
		if($args === null){
			$args= $this->_tplVars;
		}
		
		$file = isset($layout) ?  $layout.'_'.$tpl : $tpl;	
		$file = preg_replace('/[^A-Z0-9_\.-]/i', '', $file);
		
		$template = $this->_getTemplatePath($file);

		if($template == false){
        	Rb_Error::raiseError(500, "Template file : $tpl missing for app {$this->getType()}");
		}
		
		// unset so as not to introduce into template scope
		unset($tpl);

		// Support tmpl vars
        // Extracting variables here
        unset($args['this']);
        unset($args['_tplVars']);
        extract((array)$args,  EXTR_OVERWRITE);
		
		// start capturing output into a buffer
		ob_start();
		include $template;
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
	

    protected function _getTemplatePath($layout = 'default')
    {
    	static $paths = null;

    	if($paths == null){
	        $paths[] = JPATH_THEMES.'/'.UglyformsFactory::getApplication()->getTemplate()
	        			.'/html/'.UGLYFORMS_COMPONENT_NAME.
	        			'/_app/'.JString::strtolower($this->getType());

	        $paths[] = UGLYFORMS_COMPONENT_NAME.'/default'
	        			.'/_app/'.JString::strtolower($this->getType());
	        			
	        $paths[] = $this->getLocation().'/tmpl';
	        $paths[] = UGLYFORMS_COMPONENT_NAME.'/default/_partials';
    	}

        //Security Checks : clean paths
        $layout = preg_replace('/[^A-Z0-9_\.-]/i', '', $layout);

        //find the path and return
        return JPath::find($paths, $layout.'.php');
    }
    
	protected function assign($key, $value)
	{
		$this->_tplVars[$key] = $value;
	}
	
	public function getInputData($data_id) 
	{
		return UglyformsHelperData::get($data_id);
	}
}