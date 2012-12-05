<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelAction extends JXiFormsModel
{
}

class JXiFormsmodelformAction extends JXiFormsModelform 
{
	function preprocessForm($form, $data)
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
