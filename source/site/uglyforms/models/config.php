<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class UglyformsModelConfig extends UglyformsModel
{
	function save($data = array(), $pk = null, $new = false)
	{		
		$keys = array_keys($data);
		$db = UglyformsFactory::getDbo();
		$delete = " DELETE FROM `#__uglyforms_config` WHERE `key` IN ('".implode("', '", $keys)."')" ;
		
		$db->setQuery($delete)
		   ->query();
		
		
		$query  =  "INSERT INTO `#__uglyforms_config` (`key`, `value`) VALUES ";
		$queryValue = array();
		
		foreach ($data as $key => $value){
			if(is_array($value)){
				$value  = json_encode($value);
			}
			$queryValue[] = "(".$db->quote($key).",". $db->quote($value).")";
		}
		$query .= implode(",", $queryValue);
		
		return $db->setQuery($query)
		   		  ->query();  
		
	}
}

class UglyformsModelformConfig extends UglyformsModelform { }
