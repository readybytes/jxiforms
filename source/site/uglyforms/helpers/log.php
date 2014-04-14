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
	static public function create($message, $reference_id=null, $reference_type=null, $data_id=null, $level=UglyformsLog::LEVEL_ERROR)
	{
		$log = UglyformsLog::getInstance();
		
		$result  = $log->set('message', $message)
						->set('reference_id', $reference_id)
						->set('reference_type', $reference_type)
						->set('data_id', $data_id)
						->set('level', $level)
						->save();
						
		if (!$result){
			throw new Exception(Rb_Text::_('COM_UGLYFORMS_EXCEPTION_UNABLE_TO_LOG'));
		}
		
		return $result;
	}
}