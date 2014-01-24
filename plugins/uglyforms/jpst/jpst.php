<?php

/**
* @copyright		Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			Ugly Forms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author Jitendra Khatri
 *
 */
class  plgUglyformsJpst extends UglyformsPlugin
{	
	protected $_location	= __FILE__;
	
	//To Append data after submission of a form.
	public function onUglyformsDataPrepare(&$data)
	{
		//Append User ID with form data because user id is required when you want to change profile type.
		$user = UglyformsFactory::getUser();
		$data['user_id'] = $user->id;
		return true;
	}
}