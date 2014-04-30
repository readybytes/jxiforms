<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();
if(!class_exists('MCAPI')){
	require_once('MCAPI.class.php');	
}
/**
 * @author bhavya
 *
 */
class UglyformsActionMailchimp extends UglyformsAction
								implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	protected $_approval_applicable = true;
	
	public function process($input_id, $data_id)
	{
		$apiKey 		 = $this->getActionParam('mailchimpApikey', '');
		$addToLists 	 = $this->getActionParam('addToLists', '');
		$removeFromLists = $this->getActionParam('removeFromLists', '');		
		$emailFields     = explode(',', $this->getActionParam('emailField', ''));
		
		$data		= $this->getInputData($data_id)->data;
		$result 	= array();
		
		foreach ($emailFields as $key => $email){
			//if email field does not exists in data than ignore that field
			if(!empty($email) && (isset($data[$email])) && !empty($data[$email])){
				$result1 = $this->_removeFromList($data[$email], $removeFromLists, $apiKey);
				$result2 = $this->_addToList($data[$email], $addToLists, $apiKey, $data);
				$result = array_merge($result1, $result2, $result);
			}
		}
		
		if(in_array(false, $result)){
			return false;
		}

		return true;
	}
	
	protected function _addToList($emailId, $listIds, $apiKey, $data)
	{
		$api = new MCAPI($apiKey);
		if(!is_array($listIds)){
			return false;
		}
		
		$ret = array();
		foreach($listIds as $listId)
		{
			if(empty($listId)){
				continue;
			}
			
			//$info = $api->listMemberInfo($listId, $emailId);
			//last argument is passed as true which stands for update_existing email 
			//in case user already subscribed then no notification email will be sent to user
			$result = $api->listSubscribe($listId, $emailId, $data, 'html', true, true);
			
			if($result != false){
				UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_MAILCHIMP_LOG_ADDED_IN_LIST', $emailId, $listId), $this->getId(), get_class($this), $data_id, UglyformsLog::LEVEL_INFO);
			}
			else{
				UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_MAILCHIMP_LOG_FAILURE_IN_ADDING_TO_LIST', $emailId, $listId), $this->getId(), get_class($this), $data_id);
			}
			
			$ret[] = $result;
		}
		
		return $ret;
	}
	
	protected function _removeFromList($emailId, $listIds, $apiKey)
	{
		$api = new MCAPI($apiKey);
		if(!is_array($listIds)){
			return false;
		}
		
		$ret = array();
		foreach($listIds as $listId)
		{
			if(empty($listId)){
				continue;
			}
			
			$result = true;

			$memberInfo 	= $api->listMemberInfo($listId, $emailId);
			if($memberInfo['success']){
				 $info = array_shift($memberInfo['data']);
				 if(isset($info['status']) && $info['status']=='subscribed'){
					$result = $api->listUnsubscribe($listId, $emailId);
				}
			}
			
			if($result != false){
				UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_MAILCHIMP_LOG_REMOVED_FROM_LIST', $emailId, $listId), $this->getId(), get_class($this), $data_id, UglyformsLog::LEVEL_INFO);
			}
			else{
				UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_MAILCHIMP_LOG_FAILURE_IN_REMOVING_FROM_LIST', $emailId, $listId), $this->getId(), get_class($this), $data_id);
			}
			$ret[] = $result;
		}
		
		return $ret;
	}
	
	public function filterActionParams(array $data)
    {
    	$actionParams = $data['action_params'];

	    //when there is nothing set in the list then its parameter does not get posted	
    	if(!isset($data['action_params']['addToLists'])){
    		$data['action_params']['addToLists'] = array();
    	}
    	
    	if(!isset($data['action_params']['removeFromLists'])){
    		$data['action_params']['removeFromLists'] = array();
    	}
    	return parent::filterActionParams($data);
    }

}
