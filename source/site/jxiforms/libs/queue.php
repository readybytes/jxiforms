<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
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
	public static function getInstance($id = 0, $bindData = null)
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

	public function getApproved()
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
		
		$token  		= json_decode($token, true);
		$content 		= file_get_contents(JPATH_SITE.$token['filename'], null, null, $token['filepointer'], $token['length']);
		
		$regex = '#{'.$token['token'].'}(.*?){/'.$token['token'].'}#s';
		preg_match($regex,$content,$matches);
		
		if(empty($matches[1])){
			//JXITODO : read complete file with ref to the token value and update relevant data value
		}
		
		$relevant_data = json_decode($matches[1], true);

		$action = JXiformsAction::getInstance($this->getActionId());
		$result = $action->process($relevant_data['data'], $relevant_data['attachments']);
		
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
}