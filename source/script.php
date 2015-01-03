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

		//For Enabling Rb_Framework
		$extensions[] 	= array('type'=>'system',   'name'=>'rbsl');

		$this->changeExtensionState($extensions);
		return true;
	}

	function uninstall($parent)
	{
		$db = JFactory::getDBO();
		$query = "SELECT * FROM `#__extensions` WHERE `type`='plugin' AND `element`='jxiforms' AND `folder`='system'";
		$db->setQuery($query);
		$result = $db->loadObjectList('element');
		
		if(isset($result['jxiforms']))
		{
			$state=0;
			$extensions[] 	= array('type'=>'system', 'name'=>'jxiforms');
			$this->changeExtensionState($extensions, $state);
		}
		
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
	
	public function preflight($type, $parent)
	{
		if ($type != 'install' && $type != 'update'){
			return true;
		}

		$message = JText::_('ERROR_RB_NOT_FOUND : RB-Framework not found. Please refer <a href="http://www.readybytes.net/support/forum/knowledge-base/201257-error-codes.html" target="_blank">Error Codes </a> to resolve this issue.');

		// get content for rbframework version
    	$file_url   = 'http://pub.readybytes.net/rbinstaller/update/live.json';
		$link 		= new JURI($file_url);	
		$curl 		= new JHttpTransportCurl(new JRegistry());
		$response 	= $curl->request('GET', $link);
			
		if($response->code != 200){
			JFactory::getApplication()->enqueueMessage($message, 'error');
			return false;
		}
								
		$content   =  json_decode($response->body, true);
		if(!isset($content['rbframework']) || !isset($content['rbframework']['file_path'])){
			JFactory::getApplication()->enqueueMessage($message, 'error');
			return false;
		}
			
		// check if already exists
     	$db	= JFactory::getDbo();
     	$query	= $db->getQuery(true);
     
     	$query->select('*')
	     	  ->from($db->quoteName('#__extensions'))
	     	  ->where('`type` = '.$db->quote('plugin'))
	     	  ->where('`folder` = '.$db->quote('system'))
	     	  ->where('`client_id` = 0')
	     	  ->where('`element` = '.$db->quote('rbsl'));
	     	  
    	$db->setQuery($query);
		$result = $db->loadObject();
		
		//when rbframework is not already installed
		if (!$result) {
			$this->installRBFramework($content['rbframework']);
			$this->changeExtensionState(array(array('type'=>'system',   'name'=>'rbsl')));
			return true;
		}
		
		$query	= $db->getQuery(true);
     	$query->select('*')
	     	  ->from($db->quoteName('#__extensions'))
	     	  ->where('`type` = '.$db->quote('component'). ' AND  `element` LIKE '.$db->quote('com_payinvoice'). ' OR `element` LIKE '.$db->quote('com_rbinstaller'));
	     	  
     	$db->setQuery($query);
		$installed_extensions = $db->loadObjectList();
		
		//when no dependent extension is installed, install framework
		if (!$installed_extensions){
			$this->installRBFramework($content['rbframework']);
			$this->changeExtensionState(array(array('type'=>'system',   'name'=>'rbsl')));
			return true;
		}
		else {
			$params = json_decode($result->manifest_cache, true);
			
			$latest_rb_version 		=  explode('.', $content['rbframework']['version']);
			$installed_rb_version 	=  explode('.', $params['version']);
			
			//if there is no change in the major version of rbframework then install else show message
			if(version_compare($installed_rb_version[0].'.'.$installed_rb_version[1], $latest_rb_version[0].'.'.$latest_rb_version[1]) == 0
				&& version_compare($content['rbframework']['version'], $params['version']) != 0){
				$this->installRBFramework($content['rbframework']);
				if(!$result->enabled){
					$this->changeExtensionState(array(array('type'=>'system',   'name'=>'rbsl')));
				}
				return true;
			}

			$message = JText::_('ERROR_RB_MAJOR_VERSION_CHANGE : Major version change in the RB-Framework. Refer <a href="http://www.readybytes.net/support/forum/knowledge-base/201257-error-codes.html" target="_blank">Error Codes </a> to resolve this issue.');
			JFactory::getApplication()->enqueueMessage($message, 'error');
			return false;
		}
		
		return true;
	}
	
   	protected function installRBFramework($content)
 	{	
		// get file
   		$link 		=	new JUri($content['file_path']);
		$curl		= 	new JHttpTransportCurl(new JRegistry());
		$response 	=	$curl->request('GET', $link);
		
		$content_type = $response->headers['Content-Type'];
		
		if ($content_type != 'application/zip'){
			return false;
		}
		else {
			$response =  $response->body;
		}
		
		//install rb-framework kit
		$random			 = rand(1000, 999999);
		$tmp_file_name 	 = JPATH_ROOT.'/tmp/'.$random.'item_rbframework'.'_'.$content['version'].'.zip';
		$tmp_folder_name = JPATH_ROOT.'/tmp/'.$random.'item_rbframework'.'_'.$content['version'];
		
		// create a file
		JFile::write($tmp_file_name, $response);	
		
		jimport('joomla.filesystem.archive');
		jimport( 'joomla.installer.installer' );
		jimport('joomla.installer.helper');
		
		JArchive::extract($tmp_file_name, $tmp_folder_name);
		$installer = new JInstaller;

		if($installer->install($tmp_folder_name)){
				$response = true;
		}
		else{
			$response = false;
		}
		
		if (JFolder::exists($tmp_folder_name)){
			JFolder::delete($tmp_folder_name);
		}
		
		if (JFile::exists($tmp_file_name)){
			JFile::delete($tmp_file_name);
		}
		
		return $response;
    } 

	public function postflight($type, $parent)
	{
		if ($type != 'install' && $type != 'update'){
			return true;
		}

		$db		= JFactory::getDBO();
		$query	= 'SELECT * FROM `#__extensions`'
				 .'WHERE `type` LIKE "component"'
				 .'AND `element` LIKE "com_jxiforms"'
				 .'AND `enabled` =1';
				
		$db->setQuery($query);

		//redirects only when component is enabled
		if($db->loadColumn()){
			return $this->_addScript();
		}
		return true;
	}

	//Redirects After Installation
	function _addScript()
	{
		?>
			<script type="text/javascript">
				window.onload = function(){	
				  setTimeout("location.href = 'index.php?option=com_jxiforms&view=install';", 100);
				}
			</script>
		<?php
	}

}