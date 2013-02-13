<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JommlaXi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

// If file is already included
if(defined('JXIFORMS_SITE_DEFINED')){
	return;
}

//mark core loaded
define('JXIFORMS_SITE_DEFINED', true);
define('JXIFORMS_COMPONENT_NAME','jxiforms');


// define versions
define('JXIFORMS_VERSION', '@build.version@');
define('JXIFORMS_REVISION','@build.number@');

//shared paths
define('JXIFORMS_PATH_CORE',				JPATH_SITE.'/components/com_jxiforms/jxiforms');
define('JXIFORMS_PATH_CORE_MEDIA',			JPATH_ROOT.'/media/com_jxiforms');
define('JXIFORMS_PATH_CORE_FORM',			JXIFORMS_PATH_CORE.'/form');

// frontend
define('JXIFORMS_PATH_SITE', 				JPATH_SITE.'/components/com_jxiforms');
define('JXIFORMS_PATH_SITE_CONTROLLER',		JXIFORMS_PATH_SITE.'/controllers');
define('JXIFORMS_PATH_SITE_VIEW',			JXIFORMS_PATH_SITE.'/views');
define('JXIFORMS_PATH_SITE_TEMPLATE',		JXIFORMS_PATH_SITE.'/templates');

// backend
define('JXIFORMS_PATH_ADMIN', 				JPATH_ADMINISTRATOR.'/components/com_jxiforms');
define('JXIFORMS_PATH_ADMIN_CONTROLLER',	JXIFORMS_PATH_ADMIN.'/controllers');
define('JXIFORMS_PATH_ADMIN_VIEW',			JXIFORMS_PATH_ADMIN.'/views');
define('JXIFORMS_PATH_ADMIN_TEMPLATE',		JXIFORMS_PATH_ADMIN.'/templates');

// Html => form + fields
define('JXIFORMS_PATH_CORE_FORMS', 			JXIFORMS_PATH_CORE.'/html/forms');
define('JXIFORMS_PATH_CORE_FIELDS', 		JXIFORMS_PATH_CORE.'/html/fields');

//queue bucket directory and bucket
define('JXIFORMS_DEFAULT_BUCKET_PATH', 		'/media/com_jxiforms/queue/data/');
define('JXIFORMS_DEFAULT_BUCKET', 			'bucket1');

define('JXIFORMS_EXECUTION_TIME_MARGIN', 	20); //in percent



// object to identify extension, create once, so same can be consumed by constructors
Rb_Extension::getInstance(JXIFORMS_COMPONENT_NAME, array('prefix_css'=>'jxif'));
