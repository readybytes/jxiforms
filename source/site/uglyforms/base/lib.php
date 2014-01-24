<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

class UglyformsLib extends Rb_Lib
{
	public	$_component	= UGLYFORMS_COMPONENT_NAME;

	static public function getInstance($name, $id=0, $bindData=null, $dummy=null)
	{
		//IMP: dummy variable added just to remove strict errors in development mode
		Rb_Error::assert(!$dummy, Rb_Text::_('COM_UGLYFORMS_LIB_DUMMY_DATA_VALUE_MUST_NOT_BE_PASSED'));
		return parent::getInstance(UGLYFORMS_COMPONENT_NAME, $name, $id, $bindData);
	}
}
