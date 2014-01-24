<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

class UglyformsSiteControllerCron extends UglyformsController
{
	protected 	$_defaultTask = 'trigger';

	// No Model
	public function getModel()
	{
		return null;
	}
	
	public function trigger()
	{
		header("Content-type: image/png");
	    echo file_get_contents(UGLYFORMS_PATH_CORE_MEDIA.'/images/cron.png');	    

		// check if we need to trigger, dont trigger too frequently
		if(UglyformsHelperCron::checkRequired()==false){
			UglyformsHelperUtils::markExit('Cron Job Not Required');
			return false;
		}
			
		// If simultaneous requests are coming then allow only one and reject the other request
		$lock =  UglyformsLock::getInstance('uglyformsCron');
		
		if($lock->getLockResult()){			
			// trigger plugin and actions
			$args = array();

			Rb_HelperPlugin::trigger('onUglyformsCron', $args, 'uglyforms');
			
			// Mark exit
			$msg = Rb_Text::_('COM_UGLYFORMS_CRON_EXECUTED');
			UglyformsHelperUtils::markExit($msg);
	
			$date = new Rb_Date();
			$now  = $date->toUnix();

			$model = UglyformsFactory::getInstance('config', 'model');
			$model->save(array('cron_access_time'=>$now));
			
			return true;
		}
		
	   	return false;
	}
}