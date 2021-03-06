<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiformsQueue extends JXiFormsLib
{  
	protected   $queue_id  	   =   0;
	protected 	$input_id      =   0;
	protected 	$action_id     =   0;
	
	protected 	$approved	   =   1;
	protected 	$approval_key  =   '';
	
	protected 	$status	   	   =   0;
	protected 	$created_date  =   null;
	protected 	$token		   =   '';
	protected 	$params		   =   null;
	
	const STATUS_NONE			= 0;
	const STATUS_WAITING		= 1300;
	const STATUS_PROCESSED		= 1301;
	const STATUS_FAILED			= 1302;

	/**
	 * Gets the instance of JXiFormsQueue with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of queue entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object JXiformsQueue  Instance of JXiformsQueue
	 */
	public static function getInstance($id = 0, $bindData = null, $dummy = null, $dummy = null)
	{
		return parent::getInstance('queue', $id, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object JXiformsQueue Instance of JXiformsQueue
	 */
	function reset()
	{
		$this->queue_id 		= 0;
		$this->input_id			= 0;
		$this->action_id 		= 0;
		$this->approved			= 1;
		$this->approval_key		= '';
		$this->status 			= self::STATUS_NONE;
		$this->created_date		= new Rb_Date();
		$this->token			= '';
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
		//prepare data and attachements for action to process
		$token 			= $this->getToken();
		if(empty($token)){
			//JXITODO : Create Error log
		}
		
		$relevant_data  = JXiFormsHelperQueue::fetchData($token, true);

		$action = JXiformsAction::getInstance($this->getActionId());
		$result = $action->process($relevant_data['data'], $relevant_data['attachments']);
		
		//when action has been performed successfully 
		//on the data then change the status of the queue
		if($result === true ){
			$this->set('status', self::STATUS_PROCESSED)
				 ->save();
		}

		return $result;
		//JXITODO : if process is not successfull then do not change the queue status else mark it as processed
	}
	
	public function getToken()
	{
		return $this->token;
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
		$url = JUri::root().'index.php?option=com_jxiforms&view=queue&task=approve&queue_id='.$this->queue_id.'&approval_key='.$this->approval_key;
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
				self::STATUS_NONE 		=> 'COM_JXIFORMS_QUEUE_STATUS_NONE',
				self::STATUS_FAILED		=> 'COM_JXIFORMS_QUEUE_STATUS_FAILED',
				self::STATUS_PROCESSED	=> 'COM_JXIFORMS_QUEUE_STATUS_PROCESSED',
				self::STATUS_WAITING	=> 'COM_JXIFORMS_QUEUE_STATUS_WAITING'
		);
	}

	public function getInput($requireinstance=false)
	{
		if($requireinstance == JXIFORMS_INSTANCE_REQUIRE){
			return JXiformsInput::getInstance($this->queue_id);
		}
		return $this->input_id;
	}
	
	public function getAction($requireinstance=false)
	{
		if($requireinstance == JXIFORMS_INSTANCE_REQUIRE){
			return JXiformsAction::getInstance($this->action_id);
		}
		return $this->action_id;
	}
}
