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
		$inputId = JXiFormsFactory::getApplication()->input->get('input_id', 0);
		$input   = ($inputId != 0) ?  JXiformsInput::getInstance($inputId) : false; 
		$data    = JRequest::get('POST');
		
		$args = array($data, $input);
		Rb_HelperPlugin::trigger('onJxiformsInputSubmit', $args, 'jxiforms');
		
		JXiFormsFactory::getApplication()->redirect('index.php');	
	}
} 