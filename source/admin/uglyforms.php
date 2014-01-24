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
	JFactory::getApplication()->redirect('index.php?option=com_installer', 'RB-Framework Not Loaded. Either RB-Framework plugin is not installed or not enabled', 'warning');
}

require_once JPATH_SITE.'/components/com_uglyforms/uglyforms/includes.php';

// find the controller to handle the request
$option	= 'com_uglyforms';
$view	= 'dashboard';
$task	= null;
$format	= 'html';

$controllerClass = UglyformsHelper::findController($option,$view, $task,$format);


$controller = UglyformsFactory::getInstance($controllerClass, 'controller', 'uglyformsadmin');

// execute task
try{
	$controller->execute($task);
}catch(Exception $e){
	UglyformsHelper::handleException($e);
}

// lets complete the task by taking post-action
$controller->redirect();
