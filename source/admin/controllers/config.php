<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		joomlaxi@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerConfig extends JXiFormsController
{
	protected 	$_defaultTask = 'edit';
	
	public function _save(array $data, $itemId=null)
	{
		//fields with blank value does not get posted so value does not get updated in the configuration
		$modelform  = JXiFormsFactory::getInstance('config', 'Modelform' , 'Jxiforms');
		$form		= $modelform->getForm();
		$fieldset   = $form->getFieldset('config_params');

		$configParams = array();
		foreach ($fieldset as $index => $field){
				$configParams[] = $field->fieldname;
		}
		
		$postParams    = JXiFormsFactory::getApplication()->input->post->get('jxiforms_form', array(), 'array');
		$postParams    = array_keys($postParams);
		$emptyParams   = array_diff($configParams, $postParams);
		
		foreach ($emptyParams as $param){
			$data[$param] = '';
		}
		
		$model 	= $this->getModel();
		$model->save($data);
		return true;
	}
}