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

require_once  dirname(__FILE__).DS.'includes'.DS.'includes.php';

// find the controller to handle the request
//TODO : pass by reference
$controllerClass = JXiFormsHelper::findController($option='com_jxiforms',$view='dashboard', $task=null,$format='html');

$controller = JXiFormsFactory::getInstance($controllerClass, 'controller', 'jxiformssite');

// execute task
$controller->execute($task);

// lets complete the task by taking post-action
$controller->redirect();
