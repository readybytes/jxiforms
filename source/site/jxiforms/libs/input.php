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
	protected   $input_id  	   =   0;
	protected 	$title    	   =   '';
	protected 	$description   =   '';
	protected 	$published	   =	1;
	
	protected 	$post_url	   =   '';
	protected 	$redirect_url  =   '';
		
	protected 	$params		   =   null;
	
	/**
	 * Gets the instance of JXiFormsForm with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of form entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object JXiformsForm  Instance of JXiformsForm
	 */
	public static function getInstance($id = 0,  $type = null,  $bindData = null)
	{
		return parent::getInstance('input', $id, $type, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object JXiformsForm Instance of JXiformsForm
	 */
	function reset()
	{
		$this->input_id 		= 0;
		$this->title		= '';
		$this->description  = '';
		$this->published	= 1;
		$this->post_url		= '';
		$this->redirect_url = '';
		$this->params		= new Rb_Registry();

		return $this;
	}
	
}
