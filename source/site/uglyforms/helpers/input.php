<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsHelperInput extends UglyformsHelper
{
	public static function get($id = 0)
	{
		static $inputs = null;
		if(($id !== 0 && !isset($inputs[$id])) || $inputs == null){
			$inputs= UglyformsFactory::getInstance('input', 'model')->loadRecords();
		}
		
		if($id === 0){
			return $inputs;
		}
		
		if(isset($inputs[$id])){
			return $inputs[$id];
		}
		
		return false;
	}
	
	public static function recordData($input_id, $data)
	{
		if (!$input_id || empty($data)){
			throw new Exception(Rb_Text::_('COM_UGLYFORMS_EXCEPTION_NO_INPUT_ID_OR_DATA_PROVIDED'));
		}
		
		$data_model = UglyformsFactory::getInstance('data', 'model');
		
		$record['data'] 		= isset($data->data) 			? json_encode($data->data) : json_encode(array());
		$record['attachment'] 	= isset($data->attachment) 		? json_encode($data->attachment) : json_encode(array());
		$record['user_ip'] 		= isset($data->user_ip) 		? $data->user_ip : '';
		$record['input_id'] 	= $input_id;
		
		$result = $data_model->save($record);
		if (!$result){
			throw new Exception(Rb_Text::_('COM_UGLYFORMS_EXCEPTION_UNABLE_TO_RECORD_DATA'));
		}
		
		return $result;
	}
	
	public static function process($input, $input_data)
	{
		//TRIGGER : If any action or plugin want to attach some data.		
		$args     = array($input, &$input_data->data, &$input_data->attachment);
		UglyformsHelperEvent::trigger('onUglyformsDataPrepare', $args, 'uglyforms');
		
		
		$input_data->user_ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
								: ( isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : Rb_Text::_('COM_UGLYFORMS_LOGGER_REMOTE_IP_NOT_DEFINED')) ;
		
		$inputId = $input->getId();
		$data_id = UglyformsHelperInput::recordData($inputId, $input_data);

		
		//TODO : implement core checking to validate if the data is expected one or not
		//here data is validated with respect to field type of the form

		//TRIGGER onUglyformsDataValidation for validation checks injected by plugin or actions on the current form
		$args   = array($input, $data_id);
		$result = UglyformsHelperEvent::trigger('onUglyformsDataValidation', $args, 'validator', $input);
		
		if (in_array(false, $result)){
			//TODO : log data and exit
			//IMP : log data in action itself
			//redirect user to some page or on redirect url
			return false;
		}
		
		//TODO : decision based on the trigger result  
		//create queue records and dump data into file
		$queueRecs  =  UglyformsHelperQueue::enqueue($input, $data_id);
		
		$approvalContent = Rb_Text::sprintf('COM_UGLYFORMS_INPUT_DATA_SUBMITTED_ON', $input->getTitle());
		$approvalLinks    = '';
		
		
		//TODO : before process trigger for server-side validation checks
		//get applicable actions and trigger/function call for before process check
		foreach ($queueRecs as $queue){
			//if task is approved then process immediately else set the approval contents to email
			if($queue->isApproved() && $queue->getStatus() != UglyformsQueue::STATUS_PROCESSED){
				$queue->process();
			}
			else {
				$approvalLinks .= Rb_Text::sprintf('COM_UGLYFORMS_INPUT_APPROVAL_REQUEST', UglyformsHelperAction::get($queue->getActionId())->title,$queue->getApprovalUrl());
			}
		}
		
		//do not send approval email when configuration setting is set to no  
		if(!empty($approvalLinks) && UglyformsHelperConfig::get('approval_send_email')){
			UglyformsHelperQueue::sendApprovalEmail($approvalContent.$approvalLinks);
		}
		
		return true;
	}
}