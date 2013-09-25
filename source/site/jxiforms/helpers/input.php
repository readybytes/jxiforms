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
class JXiFormsHelperInput extends JXiFormsHelper
{
	public static function get($id = 0)
	{
		static $inputs = null;
		if(($id !== 0 && !isset($inputs[$id])) || $inputs == null){
			$inputs= JXiFormsFactory::getInstance('input', 'model')->loadRecords();
		}
		
		if($id === 0){
			return $inputs;
		}
		
		if(isset($inputs[$id])){
			return $inputs[$id];
		}
		
		return false;
	}
}