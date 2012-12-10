<?php
/**
* @copyright		Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			JXiForms
* @subpackage		Backend
*/
if(defined('_JEXEC')===false) die();

class Com_jxiformsInstallerScript
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
		$extensions[] 	= array('type'=>'system',   'name'=>'jxiforms');
		$extensions[] 	= array('type'=>'jxiforms', 'name'=>'email');
		$this->enableExtensions($extensions);
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
			JFolder::delete($actionPath);
		}

		return true;
	}

	function enableExtensions($extensions = array())
	{
		if(empty($extensions)){
			return true;
		}

		$state    	= 1;
		$db		= JFactory::getDBO();
		$query		= 'UPDATE '. $db->quoteName( '#__extensions' )
				. ' SET   '. $db->quoteName('enabled').'='.$db->Quote($state);

		$subQuery = array();
		$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($extensions[0]['name'])
			    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($extensions[0]['type'])
                            .'  AND `type`="plugin"  )   ';
		$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($extensions[1]['name'])
			    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($extensions[1]['type'])
                            .'  AND `type`="plugin"  )   ';

		$query .= 'WHERE '.implode(' OR ', $subQuery);

		$db->setQuery($query);
		return $db->query();
	}
}
