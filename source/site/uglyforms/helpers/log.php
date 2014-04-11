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
class UglyformsHelperLog extends UglyformsHelper
{
	static public function create($message, $reference_id=null, $reference_type=null, $data_id=null)
	{
		$model  = UglyformsFactory::getInstance('log', 'model');
		
		$record['message']		  = $message;
		$record['reference_id']   = $reference_id;
		$record['reference_type'] = $reference_type;
		$record['data_id']		  =	$data_id;

		$result = $model->save($record);
		
		if (!$result){
			throw new Exception(Rb_Text::_('COM_UGLYFORMS_EXCEPTION_UNABLE_TO_LOG'));
		}
		
		return $result;
	}
}