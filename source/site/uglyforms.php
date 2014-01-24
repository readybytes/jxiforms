<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		bhavya@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('RB_FRAMEWORK_LOADED')){
	JLog::add('RB Frameowork not loaded',JLog::ERROR);
}

require_once  dirname(__FILE__).'/uglyforms/includes.php';
$option	= 'com_uglyforms';
$view	= 'dashboard';
$task	= null;
$format	= 'html';

$controllerClass = UglyformsHelper::findController($option,$view, $task,$format);

$controller = UglyformsFactory::getInstance($controllerClass, 'controller', 'uglyformssite');

// execute task
$controller->execute($task);

//exit after controller request
if(defined('UGLYFORMS_EXIT')){
	exit(UGLYFORMS_EXIT);
}

// lets complete the task by taking post-action
$controller->redirect();
