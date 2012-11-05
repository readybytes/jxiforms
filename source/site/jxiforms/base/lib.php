<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

class JXiFormsLib extends Rb_Lib
{
	public	$_component	= JXIFORMS_COMPONENT_NAME;

	static public function getInstance($name, $id=0, $type=null, $bindData=null)
	{
		return parent::getInstance(JXIFORMS_COMPONENT_NAME, $name, $id, $type, $bindData);
	}
}
