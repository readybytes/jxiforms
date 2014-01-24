<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsHelperConfig extends UglyformsHelper
{
	static $configuration = null;
	
	public static function get($key = null)
	{
		if(self::$configuration === null || ($key !== null && !isset(self::$configuration[$key])))
		{
			$config = UglyformsFactory::getInstance('config', 'model')->loadRecords();
			
			foreach ($config as $record){
				self::$configuration[$record->key] = $record->value;
			}
			
			$modelform  = UglyformsFactory::getInstance('config', 'Modelform' , 'Uglyforms');
			$form		= $modelform->getForm();
			$fieldset   = $form->getFieldset('config_params');
			
			foreach ($fieldset as $index => $field){
				$value  = $field->value;
				if(isset(self::$configuration[$field->fieldname])){										
					$value = self::$configuration[$field->fieldname];
				}
			
				//json decode if multiple is set to true since array value is saved as json encoded
				if($field->multiple == true){
					$value = json_decode($value);
				}

				self::$configuration[$field->fieldname] = $value;
			}
		}
		
		if($key !== null){
			return self::$configuration[$key];
		}
		
		return self::$configuration;
	}
}