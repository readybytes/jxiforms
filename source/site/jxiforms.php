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

require_once  dirname(__FILE__).'/jxiforms/includes.php';
$option	= 'com_jxiforms';
$view	= 'dashboard';
$task	= null;
$format	= 'html';

$controllerClass = JXiFormsHelper::findController($option,$view, $task,$format);

$controller = JXiFormsFactory::getInstance($controllerClass, 'controller', 'jxiformssite');

// execute task
$controller->execute($task);

//exit after controller request
if(defined('JXIFORMS_EXIT')){
	exit(JXIFORMS_EXIT);
}

// lets complete the task by taking post-action
$controller->redirect();
