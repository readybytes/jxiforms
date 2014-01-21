<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsSiteViewInput extends JXiFormsSiteBaseViewInput
{
	function submit()
	{
		return true;
	}
	
	function display($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$input   =  JXiformsInput::getInstance($itemId);
		$this->assign('sample_html', $input->getHtml());
		$this->assign('input', $input);
		return true;
	}
}