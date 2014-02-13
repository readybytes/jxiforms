<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminControllerConfig extends UglyformsController
{
	protected 	$_defaultTask = 'edit';
	
	public function _save(array $data, $itemId=null)
	{
		//fields with blank value does not get posted so value does not get updated in the configuration
		$modelform  = UglyformsFactory::getInstance('config', 'Modelform' , 'Uglyforms');
		$form		= $modelform->getForm();
		$fieldset   = $form->getFieldset('config_params');

		$configParams = array();
		foreach ($fieldset as $index => $field){
				$configParams[] = $field->fieldname;
		}
		
		$postParams    = UglyformsFactory::getApplication()->input->post->get('uglyforms_form', array(), 'array');
		$postParams    = array_keys($postParams);
		$emptyParams   = array_diff($configParams, $postParams);
		
		foreach ($emptyParams as $param){
			$data[$param] = '';
		}
		
		$model 	= $this->getModel();
		$model->save($data);
		return true;
	}

	public function close()
	{
        //try to checkin
		if($this->_close()===false)
			$this->setMessage($this->getError());

		//setup redirection
		$url = Rb_Route::_("index.php?option={$this->_component->getNameCom()}&view=dashboard");
		$this->setRedirect($url);
		//as we need redirection
		return false;
	}
}