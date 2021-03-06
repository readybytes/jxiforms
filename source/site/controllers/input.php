<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteControllerInput extends JXiFormsController
{
	public function submit()
	{
		$inputId = $this->_getId();
		$input   = ($inputId != 0) ?  JXiformsInput::getInstance($inputId) : false; 
		
		if(!($input instanceof JXiformsInput)){
			throw new Exception(JText::sprintf('COM_JXIFORMS_EXCEPTION_INVALID_INPUT_ID', $inputId));
		}
		
		//if form is not published then do nothing
		if(!$input->isPublished()){
			return true;
		}
		
		$jinput = JXiFormsFactory::getApplication()->input;
		
		$postData = $jinput->post->getArray();
		$getData  = $jinput->get->getArray();
		$data 	  = array_merge($getData, $postData);
		
		//If any action's plugin want to attach some data.		
		$args     = array(&$data);
		Rb_HelperJoomla::triggerPlugin('onJXIFormsDataPrepare', $args, 'jxiforms');

		//unset token(added by RBFW for protecting against CSRF) from the submitted data 
		$formToken   = JXiFormsFactory::getSession()->getFormToken();
		unset($data[$formToken]);

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
			
			//IMP : for multiple uploads
			if (is_array($file['name'])){
				
				$multipleUpload = array();
				foreach(array_keys($file['name']) as $i) { // loop over 0,1,2,3 etc...
				   foreach(array_keys($file) as $j) { // loop over 'name', 'size', 'error', etc...
				      $multipleUpload[$i][$j] = $file[$j][$i]; // "swap" keys and copy over original array values
				   }
				}
				
				foreach ($multipleUpload as $key => $upload){
					$path  =  $this->_arrangeAttachment($upload);
					if ($path != false){
						$attachments[$name][] = $path;
					}
				}
			}
			else {
					$path  =  $this->_arrangeAttachment($file);
					if ($path != false){
						$attachments[$name][] = $path;
					}
			}
		}
		
		//create queue records and dump data into file
		$queueRecs  =  JXiFormsHelperQueue::enqueue($input);
		JXiFormsHelperQueue::appendDataToFile($queueRecs, $data, $attachments);
		
		$approvalContent = JText::sprintf('COM_JXIFORMS_INPUT_DATA_SUBMITTED_ON', $input->getTitle());
		$approvalLinks    = '';
		foreach ($queueRecs as $queue){
			//if task is approved then process immediately else set the approval contents to email
			if($queue->isApproved() && $queue->getStatus() != JXiformsQueue::STATUS_PROCESSED){
				$queue->process();
			}
			else {
				$approvalLinks .= JText::sprintf('COM_JXIFORMS_INPUT_APPROVAL_REQUEST', JXiFormsHelperAction::get($queue->getActionId())->title,$queue->getApprovalUrl());
			}
		}
		
		//do not send approval email when configuration setting is set to no  
		if(!empty($approvalLinks) && JXiFormsHelperConfig::get('approval_send_email')){
			JXiFormsHelperQueue::sendApprovalEmail($approvalContent.$approvalLinks);
		}
		
		return true;
	}
	
	public function display($cachable = false, $urlparams = array())
	{
		return parent::display($cachable, $urlparams);
	}
	
	protected function _arrangeAttachment($file)
	{
		$extension = '';
		$properties = explode('.', $file['name']);
		
		//if there is no extension attached with filename
		if(count($properties) > 1){
			$extension = '.'.array_pop($properties);
		}

		//append current time_stamp to the file name
		$tmp_name = explode('/', $file['tmp_name']);
		$filename = array_pop($tmp_name).'_'.time();
		
		$destination = JPATH_SITE.JXIFORMS_PATH_ATTACHMENTS.$filename.$extension;
		
		if(move_uploaded_file($file['tmp_name'], $destination)){
			return JXIFORMS_PATH_ATTACHMENTS.$filename.$extension;
		}
	}
} 
