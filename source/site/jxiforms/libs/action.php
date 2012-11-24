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
	protected   $is_core		   =    0;
	
	protected 	$core_params	   =   null;
	protected 	$action_params	   =   null;
	
	protected 	$_actioninputs  =   null;
	
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
		return parent::getInstance('action', $id, $type, $bindData);
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
		$this->is_core			= 0;
		$this->ordering		 	= 0;
		$this->core_params		= new Rb_Registry();
		$this->action_params	= new Rb_Registry();
		$this->_actioninputs	= array();

		return $this;
	}
	
	/**
	 * Bind the inputs(forms) with the action(app) data
	 * @return object JXiformsAction Instance of type JXiformsAction
	 */
	public function afterBind($id = 0, $data)
	{ 
		if(!$id) 
			return $this;

		//$this->_actioninputs = JXiFormsFactory::getInstance('actioninput', 'model')
		//							->getInputActions($id);

		if(isset($data['actioninputs'])){
			$this->_actioninputs = $data['_actioninputs'];
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
		return true;

		// delete all the existing values of current input_id
		$model = JXiFormsFactory::getInstance('inputaction', 'model');
		$model->deleteMany(array('action_id' => $this->getId()));

		// insert new values into inputaction for current input_id
		$data['action_id'] = $this->getId();
		if(is_array($this->_actioninputs)){
			foreach($this->_actioninputs as $input){
				$data['input_id'] = $input;
				$model->save($data);
			}
		}

		return $this;
	} 
	
}