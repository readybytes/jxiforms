<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

// if already loaded do not load
if(!defined('RB_FRAMEWORK_LOADED')){
	return;
}

// if UGLYFORMS already loaded do not load
if(defined('UGLYFORMS_CORE_LOADED')){
	return;
}

define('UGLYFORMS_CORE_LOADED', true);

// include defines
include_once dirname(__FILE__).'/defines.php';

//load core
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/base',		'',	'Uglyforms');

Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/models',		'Model',	'Uglyforms');
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/models',		'Modelform','Uglyforms');

Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/tables',		'Table',	'Uglyforms');
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/libs',			'',			'Uglyforms');
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/helpers',		'Helper',	'Uglyforms');
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/interface',		'Interface',	'Uglyforms');

//html
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/html/html',		'Html',			'Uglyforms');
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_CORE.'/html/fields',	'FormField',	'Uglyforms');



// site
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_SITE.'/controllers',	'Controller',		'UglyformsSite');
Rb_HelperLoader::addAutoLoadViews(UGLYFORMS_PATH_SITE.'/views', RB_REQUEST_DOCUMENT_FORMAT,  'UglyformsSite');

// admin
Rb_HelperLoader::addAutoLoadFolder(UGLYFORMS_PATH_ADMIN.'/controllers',	'Controller',		'UglyformsAdmin');
Rb_HelperLoader::addAutoLoadViews(UGLYFORMS_PATH_ADMIN.'/views', RB_REQUEST_DOCUMENT_FORMAT, 'UglyformsAdmin');

$filename = 'com_uglyforms_extensions';
$language = JFactory::getLanguage();
$language->load($filename, JPATH_SITE);

//load uglyforms plugins
Rb_HelperPlugin::loadPlugins('uglyforms');

require_once UGLYFORMS_PATH_CORE.'/base/event.php';