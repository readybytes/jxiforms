<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsSiteViewInput extends JXiFormsSiteBaseViewInput
{
	function submit()
	{
		return true;
	}
}