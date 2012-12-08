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
		
		Rb_Error::assert($input, Rb_Text::_('COM_JXIFORMS_ERROR_INVALID_INPUT_ID'));
		
		//collect data from get and post 
		$postData    = Rb_Request::get('POST');
		$getData     = Rb_Request::get('GET');
		$data 		 = array_merge($getData, $postData);
		
		//move the uploaded attachments file to the 
		//tmp location and pass it on to the plugins for further process
		$attachments = array();
		foreach($_FILES as $name => $file){
			if(empty($file['tmp_name'])){
				continue;
			}
			$extension = array_pop(explode('.', $file['name']));
			$destination = JPATH_ROOT.'/tmp/'.$name.'.'.$extension;
			
			if(move_uploaded_file($file['tmp_name'], $destination)){
				$attachments[$name] = $destination;	
			}
		}
		
		$args = array($input, $data, $attachments);
		Rb_HelperPlugin::trigger('onJxiformsInputSubmit', $args, 'jxiforms');
		
		//remove the attachments from tmp location after trigger
		foreach ($attachments as $attachment){
			if(JFile::exists($attachment)){
				JFile::delete($attachment);
			}
		}
		
		$url = $input->getRedirecturl();
		//TODO : routed url required
		JXiFormsFactory::getApplication()->redirect($url);	
	}
} 