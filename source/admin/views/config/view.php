<?php 
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminBaseViewConfig extends UglyformsView
{	
	function edit($tpl=null)
	{
		$modelform  = UglyformsFactory::getInstance($this->getName(), 'Modelform' , $this->_component->getPrefixClass());
		$form		= $modelform->getForm();
		
		$file = UGLYFORMS_PATH_CORE_FORMS.'/config.xml';
		$form->loadFile($file, false, '//config');
		$records = $this->getModel()->loadRecords();
		
		$data = UglyformsHelperConfig::get();
		$form->bind($data);		
		$this->assign('form', $form);

		return true;
	}
}