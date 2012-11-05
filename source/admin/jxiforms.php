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

require_once JPATH_SITE.'/components/com_jxiforms/jxiforms/includes.php';

// find the controller to handle the request
$option	= 'com_jxiforms';
$view	= 'dashboard';
$task	= null;
$format	= 'html';

$controllerClass = JXiFormsHelper::findController($option,$view, $task,$format);


$controller = JXiFormsFactory::getInstance($controllerClass, 'controller', 'jxiformsadmin');

// execute task
try{
	$controller->execute($task);
}catch(Exception $e){
	JXiFormsHelper::handleException($e);
}

// lets complete the task by taking post-action
$controller->redirect();
