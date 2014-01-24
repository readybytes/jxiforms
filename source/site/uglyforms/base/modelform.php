<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class UglyformsModelform extends Rb_Modelform
{
	public	$_component			= UGLYFORMS_COMPONENT_NAME;
	
	protected $_forms_path 		= UGLYFORMS_PATH_CORE_FORMS;
	protected $_fields_path 	= UGLYFORMS_PATH_CORE_FIELDS;
}