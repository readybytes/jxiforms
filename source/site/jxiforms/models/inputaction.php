<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelInputaction extends JXiFormsModel
{
	static $_input_actions = null;
	static $_action_inputs = null;
	
	protected static function _loadCache($query)
	{
		$query->clear('select')->clear('where');

		$action = $query->select('action_id,input_id')
					 ->dbLoadQuery()
					 ->loadObjectList();

		self::$_input_actions = array();
		self::$_action_inputs = array();
		foreach($action as $obj){
			if(isset(self::$_input_actions[$obj->input_id]) ==false){
				self::$_input_actions[$obj->input_id] = array();
			}
			
			array_push(self::$_input_actions[$obj->input_id], $obj->action_id);
			
			if(isset(self::$_action_inputs[$obj->action_id]) ==false){
				self::$_action_inputs[$obj->action_id] = array();
			}
			array_push(self::$_action_inputs[$obj->action_id], $obj->input_id);
		}
	}
	
	function getInputActions($inputId)
	{
		if(!$inputId){
			throw new Exception(Rb_Text::sprintf('COM_JXIFORMS_EXCEPTION_INVALID_INPUT_ID', $inputId));
		}
		
		if(self::$_input_actions === null){
			self::_loadCache(clone($this->getQuery()));
		}

		if(isset(self::$_input_actions[$inputId]) ===false){
			return array();
		}
		
		return self::$_input_actions[$inputId];
	}

	
	function getActionInputs($actionId)
	{
		if(!$actionId){
			throw new Exception(Rb_Text::sprintf('COM_JXIFORMS_EXCEPTION_INVALID_ACTION_ID', $actionId));
		}
		if(self::$_action_inputs === null){
			self::_loadCache(clone($this->getQuery()));
		}
		
		if(isset(self::$_action_inputs[$actionId])===false){
			return array();
		}
		
		return self::$_action_inputs[$actionId];
	}
}


class JXiFormsModelformFormaction extends JXiFormsModelform { }
