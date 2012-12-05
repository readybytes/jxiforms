<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteBaseViewInput extends JXiFormsView
{
	function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$input   =  JXiformsInput::getInstance($itemId);
		
		$this->assign('input', $input);
		$this->assign('form',  $input->getModelform()->getForm($input));
		
		return true;
	} 
}