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
class UglyformsHelperInput extends UglyformsHelper
{
	public static function get($id = 0)
	{
		static $inputs = null;
		if(($id !== 0 && !isset($inputs[$id])) || $inputs == null){
			$inputs= UglyformsFactory::getInstance('input', 'model')->loadRecords();
		}
		
		if($id === 0){
			return $inputs;
		}
		
		if(isset($inputs[$id])){
			return $inputs[$id];
		}
		
		return false;
	}
	
	public static function recordData($input_id, $data)
	{
		//TODO : throw exception
		if (!$input_id || empty($data)){
			return false;
		}
		
		$data_model = UglyformsFactory::getInstance('data', 'model');
		
		$record['data'] 		= isset($data['data']) 			? json_encode($data['data']) : json_encode(array());
		$record['attachment'] 	= isset($data['attachment']) 	? json_encode($data['attachment']) : json_encode(array());
		$record['user_ip'] 		= isset($data['user_ip']) 		? $data['user_ip'] : '';
		$record['input_id'] 	= $input_id;
		
		return $data_model->save($record);
	}
}