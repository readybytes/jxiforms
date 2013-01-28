<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModelConfig extends JXiFormsModel
{
	function save($data = array())
	{		
		$keys = array_keys($data);
		$db = JXiFormsFactory::getDbo();
		$delete = " DELETE FROM `#__jxiforms_config` WHERE `key` IN ('".implode("', '", $keys)."')" ;
		
		$db->setQuery($delete)
		   ->query();
		
		
		$query  =  "INSERT INTO `#__jxiforms_config` (`key`, `value`) VALUES ";
		$queryValue = array();
		
		foreach ($data as $key => $value){
			$queryValue[] = "(".$db->quote($key).",". $db->quote($value).")";
		}
		$query .= implode(",", $queryValue);
		
		return $db->setQuery($query)
		   		  ->query();  
		
	}
}

class JXiFormsModelformConfig extends JXiFormsModelform { }

