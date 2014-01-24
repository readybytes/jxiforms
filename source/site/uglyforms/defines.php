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
if(defined('UGLYFORMS_SITE_DEFINED')){
	return;
}

//mark core loaded
define('UGLYFORMS_SITE_DEFINED', true);
define('UGLYFORMS_COMPONENT_NAME','uglyforms');


// define versions
define('UGLYFORMS_VERSION', '@build.version@');
define('UGLYFORMS_REVISION','@build.number@');

//shared paths
define('UGLYFORMS_PATH_CORE',				JPATH_SITE.'/components/com_uglyforms/uglyforms');
define('UGLYFORMS_PATH_CORE_MEDIA',			JPATH_ROOT.'/media/com_uglyforms');
define('UGLYFORMS_PATH_CORE_FORM',			UGLYFORMS_PATH_CORE.'/form');

// frontend
define('UGLYFORMS_PATH_SITE', 				JPATH_SITE.'/components/com_uglyforms');
define('UGLYFORMS_PATH_SITE_CONTROLLER',		UGLYFORMS_PATH_SITE.'/controllers');
define('UGLYFORMS_PATH_SITE_VIEW',			UGLYFORMS_PATH_SITE.'/views');
define('UGLYFORMS_PATH_SITE_TEMPLATE',		UGLYFORMS_PATH_SITE.'/templates');

// backend
define('UGLYFORMS_PATH_ADMIN', 				JPATH_ADMINISTRATOR.'/components/com_uglyforms');
define('UGLYFORMS_PATH_ADMIN_CONTROLLER',	UGLYFORMS_PATH_ADMIN.'/controllers');
define('UGLYFORMS_PATH_ADMIN_VIEW',			UGLYFORMS_PATH_ADMIN.'/views');
define('UGLYFORMS_PATH_ADMIN_TEMPLATE',		UGLYFORMS_PATH_ADMIN.'/templates');
define('UGLYFORMS_PATH_PLUGIN', 				JPATH_PLUGINS.'/uglyforms');

// Html => form + fields
define('UGLYFORMS_PATH_CORE_FORMS', 			UGLYFORMS_PATH_CORE.'/html/forms');
define('UGLYFORMS_PATH_CORE_FIELDS', 		UGLYFORMS_PATH_CORE.'/html/fields');

//queue bucket directory and bucket
define('UGLYFORMS_PATH_BUCKET_ROOT', 		'/media/com_uglyforms/queue/data/');
define('UGLYFORMS_PATH_ATTACHMENTS', 		'/media/com_uglyforms/queue/attachments/');
define('UGLYFORMS_BUCKET_NAME',	 			'bucket1');
define('UGLYFORMS_BUCKET_CAPACITY',	 		67108864); //in bytes (64mb)

define('UGLYFORMS_INSTANCE_REQUIRE', 		true);

define('UGLYFORMS_EXECUTION_TIME_MARGIN', 	10); //in percent

define('UGLYFORMS_BUCKET_MAX_FILE_COUNT', 	32);//maximum number of files allowed in a bucket 


// object to identify extension, create once, so same can be consumed by constructors
Rb_Extension::getInstance(UGLYFORMS_COMPONENT_NAME, array('prefix_css'=>'jxif'));
