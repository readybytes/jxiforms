<?php
/**
* @copyright		Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @contact			team@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.filesystem.file');

$fileName 	= JPATH_SITE. '/components/com_jxiforms/jxiforms/includes.php';

if(!JFile::exists($fileName))
{
	return true;
}
else
{	
	$option	= JFactory::getApplication()->input->get('option');
	//do not load jxiforms when component is com_installer
	if($option == 'com_installer'){
		return true;
	}

	require_once $fileName;
	class  plgSystemJxiforms extends Rb_Plugin
	{		
		public function onAfterRoute()
		{
			//trigger system start event when component is Jxiforms
			$option	= JFactory::getApplication()->input->get('option');
			if($option != 'com_jxiforms'){
				return true;
			}
			
			//trigger system start event after loading of joomla framework
			if(defined('JXIFORMS_DEFINE_ONSYSTEMSTART')==false){
				// bug in php, subclass having issue with autoloading multiple chained classes
				// http://bugs.php.net/bug.php?id=51570
				class_exists('Rb_Plugin', true);
		
				$data = array();
				Rb_HelperPlugin::trigger('onJXiFormsSystemStart', $data, 'jxiforms');
				define('JXIFORMS_DEFINE_ONSYSTEMSTART', true);
			}
		}
	}

}
