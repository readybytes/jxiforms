<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsHelperConfig extends JXiFormsHelper
{
	static $configuration = null;
	
	public static function get($key)
	{
		if(!isset(self::$configuration[$key]))
		{
			$config = JXiFormsFactory::getInstance('config', 'model')->loadRecords();
			
			foreach ($config as $record){
				self::$configuration[$record->key] = $record->value;
			}
		}
		
		return self::$configuration[$key];
	}
}