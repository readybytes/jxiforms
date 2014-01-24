<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class UglyformsModelAction extends UglyformsModel
{
	public function delete($id=null)
	{
		if(!parent::delete($id)){
			$db = UglyformsFactory::getDBO();
			Rb_Error::raiseError(500, $db->getErrorMsg());
		}

		// delete action from inputaction table
       return UglyformsFactory::getInstance('inputaction', 'model')
						 	 ->deleteMany(array('action_id' => $id));
	}
}

class UglyformsmodelformAction extends UglyformsModelform 
{
	// action-type specific parameters needs to be binded 
	// with basic action form so relevant xml file is loaded on the action form
	function preprocessForm($form, $data)
	{
		$action_id = isset($data['action_id']) ? $data['action_id'] : 0;
		if($data['type']){
			$action = UglyformsAction::getInstance($action_id, $data['type']);
			$file = $action->getLocation().'/'.$action->getName().'.xml';
			$form->loadFile($file, false, '//config');
		}
		
		return parent::preprocessForm($form, $data);
	}
}
