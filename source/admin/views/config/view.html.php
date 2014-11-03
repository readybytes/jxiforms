<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsAdminViewConfig extends JXiFormsAdminBaseViewConfig
{
	protected function _adminEditToolbar()
	{
		JToolbarHelper::apply();
		JToolbarHelper::cancel();
	}
	
	public function edit($tpl=null)
	{
		$modelform  = JXiFormsFactory::getInstance($this->getName(), 'Modelform' , $this->_component->getPrefixClass());
		$form		= $modelform->getForm();
		
		$file = JXIFORMS_PATH_CORE_FORMS.'/config.xml';
		$form->loadFile($file, false, '//config');
		$records = $this->getModel()->loadRecords();
		
		$data = JXiFormsHelperConfig::get();
		$form->bind($data);		
		$this->assign('form', $form);

		return true;
	}
}