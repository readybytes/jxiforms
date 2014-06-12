<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteBaseViewInput extends JXiFormsView
{
	function display($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$input   =  JXiformsInput::getInstance($itemId);
		$this->assign('sample_html', $input->getHtml());
		$this->assign('input', $input);
		return true;
	} 
}