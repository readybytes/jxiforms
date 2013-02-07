<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteControllerInput extends JXiFormsController
{
	public function submit()
	{
		$inputId = $this->_getId();
		$input   = ($inputId != 0) ?  JXiformsInput::getInstance($inputId) : false; 
		
		if(!($input instanceof JXiformsInput)){
			throw new Exception(Rb_Text::sprintf('COM_JXIFORMS_EXCEPTION_INVALID_INPUT_ID', $inputId));
		}
		
		//if form is not published then do nothing
		if(!$input->isPublished()){
			return true;
		}
		
		//collect data from get and post 
		$postData    = Rb_Request::get('POST');
		$getData     = Rb_Request::get('GET');
		$data 		 = array_merge($getData, $postData);
		
		$result = $this->_submit($input, $data);
		
		$url = $input->getRedirecturl();
		//TODO : routed url required
		JXiFormsFactory::getApplication()->redirect($url);	
	}
	
	public function _submit($input, $data)
	{
		//move the uploaded attachments file to the 
		//tmp location and pass it on to the plugins for further process
		$attachments = array();
		foreach($_FILES as $name => $file){
			if(empty($file['tmp_name'])){
				continue;
			}
			$extension = array_pop(explode('.', $file['name']));
			$filename = array_pop(explode('/', $file['tmp_name']));
			
			//JXITODO : what if multiple attachments are of same name
			$destination = JXIFORMS_PATH_CORE_MEDIA.'/queue/attachments/'.$filename.'.'.$extension;
			
			if(move_uploaded_file($file['tmp_name'], $destination)){
				$attachments[$name] = $destination;	
			}
		}
		
		//create queue records and dump data into file
		$queueRecs  =  JXiFormsHelperQueue::enqueue($input);
		JXiFormsHelperQueue::appendDataToFile($queueRecs, $data, $attachments);
		
		$approvalContent = '';
		foreach ($queueRecs as $queue){
			//if task is approved then process immediately else set the approval contents to email
			if($queue->isApproved() && $queue->getStatus() != JXiformsQueue::STATUS_PROCESSED){
				$queue->process();
			}
			else {
				$approvalContent .= $queue->getApprovalUrl()."\n";
			}
		}
		
		//do not send approval email when configuration setting is set to no  
		if(!empty($approvalContent) && JXiFormsHelperConfig::get('approval_send_email')){
			JXiFormsHelperQueue::sendApprovalEmail($approvalContent);
		}
		
		return true;
	}
	
	public function display()
	{
		return true;
	}
} 