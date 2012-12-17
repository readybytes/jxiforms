<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiformsInput extends JXiFormsLib
{
	//IMP: Input entity will be displayed as form  
	protected   $input_id  	   =   0;
	protected 	$title    	   =   '';
	protected 	$description   =   '';
	protected 	$published	   =	1;
	
	protected 	$post_url	   =   '';
	protected 	$redirect_url  =   'index.php';
		
	protected 	$params		   =   null;
	
	protected 	$_input_actions  =   null;
	
	/**
	 * Gets the instance of JXiFormsInput with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of input entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object JXiformsInput  Instance of JXiformsInput
	 */
	public static function getInstance($id = 0, $bindData = null)
	{
		return parent::getInstance('input', $id, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object JXiformsInput Instance of JXiformsInput
	 */
	function reset()
	{
		$this->input_id 		= 0;
		$this->title		= '';
		$this->description  = '';
		$this->published	= 1;
		$this->post_url		= '';
		$this->redirect_url = 'index.php';
		$this->params		= new Rb_Registry();
		$this->_input_actions= array();

		return $this;
	}
	
	/**
	 * Bind the actions(apps) with the input(form) data
	 * @return object JXiformsInput Instance of type JXiformsInput
	 */
	public function afterBind($id = 0, $data)
	{ 
		if($id) {
			$this->_input_actions = JXiFormsFactory::getInstance('inputaction', 'model')
										->getInputActions($id);
		}
		
		if(isset($data['_input_actions'])){
			$this->_input_actions = is_array($data['_input_actions']) ? $data['_input_actions'] : array($data['_input_actions']);
		}
									
		return $this;
	}
	
	/**
	 * Save the input and its association with actions in inputaction table
	 * Attach the posturl with object if empty
	 * 
	 * @return object JXiformsInput  Instance of JXiformsInput
	 */
	public function save()
	{
		if(!parent::save()){
			return false;
		}
		
		$posturl = $this->getPosturl(); 
		if(empty($posturl)){
			$this->post_url = 'index.php?option=com_jxiforms&view=input&task=submit&input_id='.$this->getId();
			$this->save();
		}
		
		return $this->_saveInputActions();
	}
	
	/**
	 * Gets the posturl of the input form
	 * @return string Url on which form data will be posted
	 */
	public function getPosturl()
	{
		return $this->post_url;
	}
	
	/**
	 * Save input association with the action
	 * @return object JXiformsInput  Instance of type JXiformsInput
	 */
	private function _saveInputActions()
	{
		// delete all the existing values of current input_id
		$model = JXiFormsFactory::getInstance('inputaction', 'model');
		$model->deleteMany(array('input_id' => $this->getId()));

		// insert new values into inputaction for current input_id
		$data['input_id'] = $this->getId();
		if(is_array($this->_input_actions)){
			foreach($this->_input_actions as $action){
				$data['action_id'] = $action;
				$model->save($data);
			}
		}

		return $this;
	} 
	
	public function getInputs()
	{
		return array($this->getId());
	}
	
	public function getActions()
	{
		return $this->_input_actions;
	}
	
	/**
	 * Gets the redirect url of the input form
	 * @return string Url on which user will be redirected
	 */
	public function getRedirecturl()
	{
		return $this->redirect_url;
	}
}