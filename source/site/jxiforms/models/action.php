<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms	
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelAction extends JXiFormsModel
{
	public function delete($id=null)
	{
		if(!parent::delete($id)){
			$db = JXiFormsFactory::getDBO();
			Rb_Error::raiseError(500, $db->getErrorMsg());
		}

		// delete action from inputaction table
       return JXiFormsFactory::getInstance('inputaction', 'model')
						 	 ->deleteMany(array('action_id' => $id));
	}
}

class JXiFormsmodelformAction extends JXiFormsModelform 
{
	// action-type specific parameters needs to be binded 
	// with basic action form so relevant xml file is loaded on the action form
	function preprocessForm(JForm $form, $data, $group=null)
	{
		$action_id = isset($data['action_id']) ? $data['action_id'] : 0;
		if($data['type']){
			$action = JXiformsAction::getInstance($action_id, $data['type']);
			$file = $action->getLocation().'/'.$action->getName().'.xml';
			$form->loadFile($file, false, '//config');
		}
		
		return parent::preprocessForm($form, $data);
	}
}
