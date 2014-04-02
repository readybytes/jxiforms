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
		
		$input_data = new stdClass();
		$input_data->data 		=  array_merge($getData, $postData);
		$input_data->attachment = $this->_collectAttachments($_FILES);
		
		$result = UglyformsHelperInput::process($input, $input_data);
		
		if ($result == false){
			//TODO : display message and link to current form
			//checking whether form is displayed by uglyforms or some custom form is used
			$error_url = $input->getParam('error_url', Rb_Route::_("index.php?option=com_uglyforms&view=input&task=error", false));
			$this->setRedirect($error_url);
			return false;
		}
		
		//TODO : routed url needed
		$redirect_url = $input->getParam('redirect_url', Rb_Route::_("index.php?option=com_uglyforms&view=input&task=complete", false));
		$this->setRedirect($redirect_url);
		return false;
	}
		
	function _collectAttachments($files)
	{
		//TODO : implement security for attachments

		//move the uploaded attachments file to the 
		//tmp location and pass it on to the plugins for further process
		$attachments = array();
		foreach($files as $name => $file){
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
		
		return $attachments;
	}
	
	public function display($cachable = false, $urlparams = array())
	{
		return parent::display($cachable, $urlparams);
	}	
	
	public function complete()
	{
		$this->setTemplate('complete');
		return true;
	}
	
	public function error()
	{
		$this->setTemplate('error');
		return true;
	}
}