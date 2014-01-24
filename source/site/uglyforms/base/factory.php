<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

class UglyformsFactory extends Rb_Factory
{
	static function getInstance($name, $type='', $prefix='uglyforms', $refresh=false)
	{
		return parent::getInstance($name, $type, $prefix, $refresh);
	}
}
