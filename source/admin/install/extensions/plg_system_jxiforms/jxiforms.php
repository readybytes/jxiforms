<?php
/**
* @copyright        Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license        GNU/GPL, see LICENSE.php
* @contact        team@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.filesystem.file');

$fileName     = JPATH_SITE. '/components/com_jxiforms/jxiforms/includes.php';

if(!JFile::exists($fileName))
{
    return true;
}
else
{    
    $option    = JFactory::getApplication()->input->get('option');
    //do not load jxiforms when framework is not loaded
    if(!defined('RB_FRAMEWORK_LOADED')){
	return true;
    }

    require_once $fileName;
    class  plgSystemJxiforms extends Rb_Plugin
    {
   		function onAfterRender()
		{
			// Only do if configuration say so : cron_run_automatic is set to 1
			if(JXiFormsHelperConfig::get('cron_run_automatic') != 1){
				return;
			}
			
			// Only render for HTML output
			if (JXiFormsFactory::getDocument()->getType() !== 'html' ) { return; }

			//only add if required, then add call back
			if(JXiFormsHelperCron::checkRequired()== true){
				// Add a cron call back			
				$cron = '<img src="'.JXiFormsHelperCron::getURL().'" />';
				$body = JResponse::getBody();
				$body = str_replace('</body>', $cron.'</body>', $body);
				JResponse::setBody($body);
			}
		}
    }

}
