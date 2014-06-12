<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license	GNU/GPL, see LICENSE.php
* @package	support+jxiforms@readybytes.in
* @subpackage		Backend
*/
if(defined('_JEXEC')===false) die();

class pkg_JxiFormsInstallerScript
{
	function postflight($type, $parent)
	{
		//For Enabling RbFramework
		$extension   = array();
		$extension[] = array('type'=>'system',   'name'=>'rbsl');
		$this->changeExtensionState($extension);
		return $this->_addScript();
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

	//Enable Plugin of RBSL Framework
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
