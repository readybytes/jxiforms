<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/
if(defined('_JEXEC')===false) die();

class JXiFormsLib extends Rb_Lib
{
	public	$_component	= JXIFORMS_COMPONENT_NAME;

	static public function getInstance($name, $id=0, $bindData=null, $dummy=null)
	{
		//IMP: dummy variable added just to remove strict errors in development mode
		Rb_Error::assert(!$dummy, Rb_Text::_('COM_JXIFORMS_LIB_DUMMY_DATA_VALUE_MUST_NOT_BE_PASSED'));
		return parent::getInstance(JXIFORMS_COMPONENT_NAME, $name, $id, $bindData);
	}
}
