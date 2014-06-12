<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelform extends Rb_Modelform
{
	public	$_component			= JXIFORMS_COMPONENT_NAME;
	
	protected $_forms_path 		= JXIFORMS_PATH_CORE_FORMS;
	protected $_fields_path 	= JXIFORMS_PATH_CORE_FIELDS;
}