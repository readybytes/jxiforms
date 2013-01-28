<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		joomlaxi@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminControllerConfig extends JXiFormsController
{
	protected 	$_defaultTask = 'edit';
	
	public function _save(array $data, $itemId=null)
	{
		$model 	= $this->getModel();
		$model->save($data);
		return true;
	}
}