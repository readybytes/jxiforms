<?php
/**
* @copyright		Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			Uglyforms
* @subpackage		Backend
*/
if(defined('_JEXEC')===false) die();

class Com_uglyformsInstallerScript
{
	
	/**
	 * Runs on installation
	 * 
	 * @param JInstaller $parent 
	 */
	public function install($parent)
	{
		$this->installExtensions();

		$extensions 	= array();
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'email');
		$extensions[] 	= array('type'=>'system', 'name'=>'uglyforms');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'joomlalogin');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'dropbox');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'mailchimp');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'joomlaregistration');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'ack');
		$extensions[] 	= array('type'=>'uglyforms', 'name'=>'resetpassword');
		//For Enabling Rb_Framework
		$extensions[] 	= array('type'=>'system',   'name'=>'rbsl');

		$this->changeExtensionState($extensions);
		return true;
	}

	function uninstall($parent)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM `#__extensions` WHERE `type`='plugin' AND `element`='uglyforms' AND `folder`='system'";
		$db->setQuery($query);
		$result = $db->loadObjectList('element');
		
		if(isset($result['uglyforms']))
		{
			$state=0;
			$extensions[] 	= array('type'=>'system', 'name'=>'uglyforms');
			$this->changeExtensionState($extensions, $state);
		}
		
		return true;
	}

	
	function update($parent)
	{
		self::install($parent);
	}

	function installExtensions($actionPath=null,$delFolder=true)
	{
		//if no path defined, use default path
		if($actionPath==null)
			$actionPath = dirname(__FILE__).'/admin/install/extensions';

		//get instance of installer
		$installer =  new JInstaller();

		$extensions	= JFolder::folders($actionPath);

		//no extension to install
		if(empty($extensions))
			return true;

		//install all extensions
		foreach ($extensions as $extension)
		{
			$msg = " ". $extension . ' : Installed Successfully ';

			// Install the packages
			if($installer->install("{$actionPath}/{$extension}")==false){
				$msg = " ". $extension . ' : Installation Failed. Please try to reinstall. [Supportive plugin/module for PayPlans]';
			}

			//enque the message
			JFactory::getApplication()->enqueueMessage($msg);
		}

		if($delFolder){
			$delPath = JPATH_ADMINISTRATOR.'/components/com_uglyforms/install/extensions';
			JFolder::delete($delPath);
		}

		return true;
	}

	function changeExtensionState($extensions = array(), $state = 1)
	{
		if(empty($extensions)){
			return true;
		}

		$db		= JFactory::getDBO();
		$query		= 'UPDATE '. $db->quoteName( '#__extensions' )
				. ' SET   '. $db->quoteName('enabled').'='.$db->Quote($state);

		$subQuery = array();
		foreach($extensions as $extension => $value){
			$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($value['name'])
				    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($value['type'])
			            .'  AND `type`="plugin"  )   ';
		}

		$query .= 'WHERE '.implode(' OR ', $subQuery);

		$db->setQuery($query);
		return $db->query();
	}
}
