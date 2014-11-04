<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

include_once dirname(__FILE__).'/view.php';

class JXiFormsAdminViewInstall extends JXiFormsAdminBaseViewInstall
{
	public function complete()
	{
		$app = JXiFormsFactory::getApplication();
		$app->redirect("index.php?option=com_jxiforms&view=dashboard");
		
		return true;
	}
	
	public function display($cachable = false, $urlparams = array())
	{
		$app = JXiFormsFactory::getApplication();
		$db_prefix = $app->get('dbprefix', '');
		
		$db = JXiFormsFactory::getDbo();
		$tables = $db->getTableList();
		
		$email = '';
		if (!in_array($db_prefix.'rbinstaller_config', $tables)){
			$this->assign('email', $email);
			return true;
		}
		
		$query	= 'SELECT * FROM `#__rbinstaller_config`'
			 .'WHERE `key` = "email"';
			
		$db->setQuery($query);
		$object = $db->loadObject();
		
		if($object){
			$email = $object->value;
		}
		
		$this->assign('email', $email);
		return true;
	}
}