<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();

// if already loaded do not load
if(!defined('RB_FRAMEWORK_LOADED')){
	return;
}

// if JXIFORMS already loaded do not load
if(defined('JXIFORMS_CORE_LOADED')){
	return;
}

define('JXIFORMS_CORE_LOADED', true);

// include defines
include_once dirname(__FILE__).'/defines.php';

//load core
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/base',		'',	'JXiForms');

Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/models',		'Model',	'JXiForms');
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/models',		'Modelform','JXiForms');

Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/tables',		'Table',	'JXiForms');
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/libs',			'',			'JXiForms');
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/helpers',		'Helper',	'JXiForms');

//html
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/html/html',		'Html',			'JXiForms');
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_CORE.'/html/fields',	'FormField',	'JXiForms');



// site
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_SITE.'/controllers',	'Controller',		'JXiFormsSite');
Rb_HelperLoader::addAutoLoadViews(JXIFORMS_PATH_SITE.'/views', RB_REQUEST_DOCUMENT_FORMAT,  'JXiFormsSite');

// admin
Rb_HelperLoader::addAutoLoadFolder(JXIFORMS_PATH_ADMIN.'/controllers',	'Controller',		'JXiFormsAdmin');
Rb_HelperLoader::addAutoLoadViews(JXIFORMS_PATH_ADMIN.'/views', RB_REQUEST_DOCUMENT_FORMAT, 'JXiFormsAdmin');

$filename = 'com_jxiforms_extensions';
$language = JFactory::getLanguage();
$language->load($filename, JPATH_SITE);

require_once JXIFORMS_PATH_CORE.'/base/event.php';