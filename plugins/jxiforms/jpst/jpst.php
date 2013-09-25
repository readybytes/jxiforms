<?php

/**
* @copyright		Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			JoomlaXi Forms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author Jitendra Khatri
 *
 */
class  plgJxiformsJpst extends JXiFormsPlugin
{	
	protected $_location	= __FILE__;
	
	//To Append data after submission of a form.
	public function onJXIFormsDataPrepare(&$data)
	{
		//Append User ID with form data because user id is required when you want to change profile type.
		$user = JXiFormsFactory::getUser();
		$data['user_id'] = $user->id;
		return true;
	}
}