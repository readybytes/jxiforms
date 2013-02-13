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
class JXiFormsHelperCron extends JXiFormsHelper
{
	public static function getURL()
	{
		// Give public URL
		return JURI::root().'index.php?option=com_jxiforms&view=cron&task=trigger';
	}
	
	public static function checkRequired($config = null)
	{
		if($config === null){
			$config = JXiFormsHelperConfig::get();
		}
		
		$frequency 			= $config['cron_frequency'];
		$accessTime 		= $config['cron_access_time'];
		
		$now = new Rb_Date();
		$now = $now->toUnix();
		
		// if diff of $now and $cron_access_time is greater than $frequency then return true
		if(($now - $accessTime) > $frequency){
			return true;
		}	
		
		return false;
	}
}