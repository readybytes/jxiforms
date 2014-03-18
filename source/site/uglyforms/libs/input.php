<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsInput extends UglyformsLib
{
	//IMP: Input entity will be displayed as form  
	protected   $input_id  	   =   0;
	protected 	$title    	   =   '';
	protected 	$description   =   '';
	protected 	$published	   =	1;
	
	protected 	$redirect_url  =   'index.php';
		
	protected 	$params		   =   null;
	
	protected 	$_input_actions  =   null;
	
	/**
	 * Gets the instance of UglyformsInput with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of input entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object UglyformsInput  Instance of UglyformsInput
	 */
	public static function getInstance($id = 0, $bindData = null)
	{
		return parent::getInstance('input', $id, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object UglyformsInput Instance of UglyformsInput
	 */
	function reset()
	{
		$this->input_id 		= 0;
		$this->title		= '';
		$this->description  = '';
		$this->published	= 1;
		$this->redirect_url = 'index.php';
		$this->params		= new Rb_Registry();
		$this->_input_actions= array();

		return $this;
	}
	
	/**
	 * Bind the actions(apps) with the input(form) data
	 * @return object UglyformsInput Instance of type UglyformsInput
	 */
	public function afterBind($id = 0, $data)
	{ 
		if($id) {
			$this->_input_actions = UglyformsFactory::getInstance('inputaction', 'model')
										->getInputActions($id);
		}
		
		if(isset($data['_input_actions'])){
			$this->_input_actions = is_array($data['_input_actions']) ? $data['_input_actions'] : array($data['_input_actions']);
		}
									
		return $this;
	}
	
	/**
	 * Save the input and its association with actions in inputaction table
	 * 
	 * @return object UglyformsInput  Instance of UglyformsInput
	 */
	public function save()
	{
		if(!parent::save()){
			return false;
		}
		
		return $this->_saveInputActions();
	}
	
	/**
	 * Gets the posturl of the input form
	 * @return string Url on which form data will be posted
	 */
	public function getPosturl()
	{
		return 'index.php?option=com_uglyforms&view=input&task=submit&input_id='.$this->getId();
	}
	
	/**
	 * Save input association with the action
	 * @return object UglyformsInput  Instance of type UglyformsInput
	 */
	private function _saveInputActions()
	{
		// delete all the existing values of current input_id
		$model = UglyformsFactory::getInstance('inputaction', 'model');
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
	
	public function isPublished()
	{
		return $this->published;
	}
	
	public function getRecentHtml()
	{
		$inputhtml = $this->getRecentInputhtml();
		
		if ($inputhtml == false){
			return '';
		}
		
		return $inputhtml->html;
	}
	
	public function getTitle()
	{
		return $this->title;
	}
	
	public function getRecentFormJson()
	{
		$inputhtml = $this->getRecentInputhtml();
		
		if ($inputhtml == false){
			return '';
		}
		
		return $inputhtml->json;
	}
	
	public function getRecentInputhtml()
	{
		$html_records = UglyformsFactory::getInstance('inputhtml', 'model')
										->loadRecords(array('input_id'=>$this->getId()));

		if (empty($html_records)){
			return false;
		}
		
		$html = array_pop($html_records);
		return $html;
	}
	
}