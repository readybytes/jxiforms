<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsSiteControllerInput extends UglyformsController
{
	public function submit()
	{
		$inputId = $this->_getId();
		$input   = ($inputId != 0) ?  UglyformsInput::getInstance($inputId) : false; 
		
		if(!($input instanceof UglyformsInput)){
			throw new Exception(Rb_Text::sprintf('COM_UGLYFORMS_EXCEPTION_INVALID_INPUT_ID', $inputId));
		}
		
		//if form is not published then do nothing
		if(!$input->isPublished()){
			return true;
		}
		
		//collect data from get and post 
		$postData    = Rb_Request::get('POST');
		$getData     = Rb_Request::get('GET');
		$data 		 = array_merge($getData, $postData);
		
		//If any action's plugin want to attach some data.		
		$args     = array(&$data);
		Rb_HelperPlugin::trigger('onUglyformsDataPrepare', $args, 'uglyforms');

		//unset token(added by RBFW for protecting against CSRF) from the submitted data 
		$formToken   = UglyformsFactory::getSession()->getFormToken();
		unset($data[$formToken]);
		
		$result = $this->_submit($input, $data);
		
		$url = $input->getRedirecturl();
		//TODO : routed url required
		UglyformsFactory::getApplication()->redirect($url);	
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

			$extension = '';
			$properties = explode('.', $file['name']);
			
			//if there is no extension attached with filename
			if(count($properties) > 1){
				$extension = '.'.array_pop($properties);
			}

			//append current time_stamp to the file name
			$tmp_name = explode('/', $file['tmp_name']);
			$filename = array_pop($tmp_name).'_'.time();
			
			$destination = JPATH_SITE.UGLYFORMS_PATH_ATTACHMENTS.$filename.$extension;
			
			if(move_uploaded_file($file['tmp_name'], $destination)){
				$attachments[$name] = UGLYFORMS_PATH_ATTACHMENTS.$filename.$extension;	
			}
		}
		
		//create queue records and dump data into file
		$queueRecs  =  UglyformsHelperQueue::enqueue($input);
		UglyformsHelperQueue::appendDataToFile($queueRecs, $data, $attachments);
		
		$approvalContent = Rb_Text::sprintf('COM_UGLYFORMS_INPUT_DATA_SUBMITTED_ON', $input->getTitle());
		$approvalLinks    = '';
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