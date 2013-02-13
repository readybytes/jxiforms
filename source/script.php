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
		$extensions[] 	= array('type'=>'jxiforms', 'name'=>'email');
		$extensions[] 	= array('type'=>'system', 'name'=>'jxiforms');
		$this->enableExtensions($extensions);
		return true;
	}
	
	function update($parent)
	{
		self::install($parent);
		$this->alterInputTable();
		$this->addQueueSchema();
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
			$delPath = JPATH_ADMINISTRATOR.'/components/com_jxiforms/install/extensions';
			JFolder::delete($delPath);
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
		foreach($extensions as $extension => $value){
			$subQuery[] = '('.$db->quoteName('element').'='.$db->Quote($value['name'])
				    . ' AND ' . $db->quoteName('folder').'='.$db->Quote($value['type'])
			            .'  AND `type`="plugin"  )   ';
		}

		$query .= 'WHERE '.implode(' OR ', $subQuery);

		$db->setQuery($query);
		return $db->query();
	}
	
	function alterInputTable()
	{
		$db = JFactory::getDBO();
		$columns = $db->getTableColumns('#__jxiforms_input');
		if(isset($columns['html'])){
			return true;
		}
		
		$query = ' ALTER TABLE '.$db->quoteName( '#__jxiforms_input')
				 .' ADD '. $db->quoteName('html').' TEXT  NULL ';
				 
		$db->setQuery($query);
		return $db->query();
	}

	function addQueueSchema()
	{
		$db = JFactory::getDBO();
		
		$query = "CREATE TABLE IF NOT EXISTS `#__jxiforms_queue` (
				  `queue_id`		INT(11)			NOT NULL AUTO_INCREMENT,
				  `input_id`		INT(11) 		NOT NULL,
				  `action_id` 		INT(11)			NOT NULL,
				  `approved`		TINYINT(1) 		DEFAULT 1,
				  `approval_key`	VARCHAR(255)	DEFAULT NULL,
				  `status`			INT(4) 			DEFAULT 0,
				  `created_date`	DATETIME		NOT NULL,
				  `token` 			TEXT			DEFAULT NULL,
				  `params` 			TEXT			DEFAULT NULL,
				  PRIMARY KEY (`queue_id`),
				  INDEX `idx_input_id` (`input_id` ASC),
				  INDEX `idx_action_id` (`action_id` ASC),
				  INDEX `idx_approved` (`approved` ASC),
				  INDEX `idx_status` (`status` ASC)
				) 
				ENGINE = MyISAM 
				DEFAULT CHARACTER SET = utf8";
				 
		$db->setQuery($query);
		return $db->query();
	}
}
