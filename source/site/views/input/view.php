<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsSiteBaseViewInput extends JXiFormsView
{
	function display($tpl= null, $itemId = null)
	{
		$itemId  	= ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$input   	= JXiformsInput::getInstance($itemId);
		$htmlToAdd	= '<form name="'.$input->getTitle().'" method="POST" action="'.$input->getPosturl().'" >';
		$html		= $htmlToAdd.$input->getHtml().'<input type="submit" value="Submit"/></form>';
		$this->assign('sample_html', $html);
		$this->assign('input', $input);
		return true;
	} 
}