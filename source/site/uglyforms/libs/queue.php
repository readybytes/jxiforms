<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsQueue extends UglyformsLib
{  
	protected   $queue_id  	   =   0;
	protected 	$input_id      =   0;
	protected 	$action_id     =   0;
	
	protected 	$approved	   =   1;
	protected 	$approval_key  =   '';
	
	protected 	$status	   	   =   0;
	protected 	$created_date  =   null;
	protected 	$data_id	   =   0;
	protected 	$params		   =   null;
	
	const STATUS_NONE			= 0;
	const STATUS_WAITING		= 1300;
	const STATUS_PROCESSED		= 1301;
	const STATUS_FAILED			= 1302;
	const STATUS_INVALID		= 1303;

	/**
	 * Gets the instance of UglyformsQueue with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of queue entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object UglyformsQueue  Instance of UglyformsQueue
	 */
	public static function getInstance($id = 0, $bindData = null)
	{
		return parent::getInstance('queue', $id, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object UglyformsQueue Instance of UglyformsQueue
	 */
	function reset()
	{
		$this->queue_id 		= 0;
		$this->input_id			= 0;
		$this->action_id 		= 0;
		$this->approved			= 1;
		$this->approval_key		= '';
		$this->data_id			= 0;
		$this->status 			= self::STATUS_NONE;
		$this->created_date		= new Rb_Date();
		$this->params		 	= new Rb_Registry();

		return $this;
	}

	public function isApproved()
	{
		return $this->approved;
	}
	
	public function getActionId()
	{
		return $this->action_id;
	}
	
	public function process()
	{
		$action = UglyformsAction::getInstance($this->getActionId());
		
		//TODO : trigger before processing action 
		//TODO : update all the actions since another variable added in process function call
		//TODO : throw exception when method does not exists rather than setting default result
		$result = false;
		if (method_exists($action, 'process')){ 
			$result = $action->process($this->input_id, $this->data_id);
			
			//when action has been performed successfully 
			//on the data then change the status of the queue
			if($result === true ){
				$this->set('status', self::STATUS_PROCESSED)
					 ->save();
			}
		}

		return $result;
		//JXITODO : if process is not successfull then do not change the queue status else mark it as processed
	}
	
	
	public function getApprovalKey()
	{
		return $this->approval_key;
	}
	
	public function approve()
	{
		//cron can be triggered after approval so that work can be processed 
		return $this->set('approved', 1)
			 		->save();
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function getApprovalUrl()
	{
		$url = JUri::root().'index.php?option=com_uglyforms&view=queue&task=approve&queue_id='.$this->queue_id.'&approval_key='.$this->approval_key;
		return $url;
	}

	/**
	 * Gets all the status of Queue
	 * 
	 * @return Array 
	 */	
	public static function getStatusList()
	{
		return array(
				self::STATUS_NONE 		=> 'COM_UGLYFORMS_QUEUE_STATUS_NONE',
				self::STATUS_FAILED		=> 'COM_UGLYFORMS_QUEUE_STATUS_FAILED',
				self::STATUS_PROCESSED	=> 'COM_UGLYFORMS_QUEUE_STATUS_PROCESSED',
				self::STATUS_WAITING	=> 'COM_UGLYFORMS_QUEUE_STATUS_WAITING'
		);
	}

	public function getInput($requireinstance=false)
	{
		if($requireinstance == UGLYFORMS_INSTANCE_REQUIRE){
			return UglyformsInput::getInstance($this->queue_id);
		}
		return $this->input_id;
	}
	
	public function getAction($requireinstance=false)
	{
		if($requireinstance == UGLYFORMS_INSTANCE_REQUIRE){
			return UglyformsAction::getInstance($this->action_id);
		}
		return $this->action_id;
	}
	
	public function getInputData()
	{
		return UglyformsHelperData::get($this->data_id);
	}
}
