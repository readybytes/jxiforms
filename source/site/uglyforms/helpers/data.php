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
		}
				
		if(isset($record[$id])){
			$record[$id]->data  		= json_decode($record[$id]->data, true);
			$record[$id]->attachment  	= json_decode($record[$id]->attachment, true);
			return $record[$id];
		}
		
		$record[$id]->data_id = 0;
		$record[$id]->data = array();
		$record[$id]->attachment = array();
		$record[$id]->input_id = 0;
		$record[$id]->create_date = '';
		$record[$id]->user_ip = '';
	
		return $record[$id];
	}
}