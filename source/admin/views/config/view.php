<?php 
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewConfig extends JXiFormsView
{	
	function edit($tpl=null)
	{
		$modelform  = JXiFormsFactory::getInstance($this->getName(), 'Modelform' , $this->_component->getPrefixClass());
		$form		= $modelform->getForm();
		
		$file = JXIFORMS_PATH_CORE_FORMS.'/config.xml';
		$form->loadFile($file, false, '//config');
		$records = $this->getModel()->loadRecords();
		
		$data = array();
		foreach ($records as $record){
			$data[$record->key] = $record->value;
		}
		
		$form->bind($data);		
		$this->assign('form', $form);

		return true;
	}
}