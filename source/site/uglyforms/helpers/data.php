<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsHelperData extends UglyformsHelper
{
	public static function get($id = 0)
	{
		static $record = null;
		if(($id !== 0 && !isset($record[$id])) || $record == null){
			$record= UglyformsFactory::getInstance('data', 'model')
									->loadRecords(array('data_id'=>$id));

			foreach ($record as $key=>$value){
				$record[$key]->data  		= json_decode($record[$key]->data, true);
				$record[$key]->attachment  	= json_decode($record[$key]->attachment, true);
			}
		}
				
		if(isset($record[$id])){
			return $record[$id];
		}
		
		$record[$id]->data_id = 0;
		$record[$id]->data = array();
		$record[$id]->attachment = array();
		$record[$id]->input_id = 0;
		$record[$id]->create_date = '';
		$record[$id]->user_ip = '';
		$record[$id]->user_id = 0;
	
		return $record[$id];
	}
}