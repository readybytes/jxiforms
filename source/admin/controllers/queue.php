<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerQueue extends JXiFormsController
{
	//JXITODO : remove this code when fix has been implemented in the framework
	public function _save(array $data, $itemId=null)
	{
		$queue = JXiformsQueue::getInstance($itemId);

		//create new lib instance
		return $queue->bind($data)
  			         ->save();	
	}
} 