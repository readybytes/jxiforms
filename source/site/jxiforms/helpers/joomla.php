<?php 
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsHelperJoomla extends JXiFormsHelper
{
	public static function getUsersByGroup($groupId, $recursive = false)
	{
		$db = JXiFormsFactory::getDbo();
		$test = $recursive ? '>=' : '=';

		// First find the users contained in the group
		$query  = new Rb_Query();
		$query->select('DISTINCT(user_id)');
		$query->from('#__usergroups as ug1');
		$query->join('INNER', '#__usergroups AS ug2 ON ug2.lft' . $test . 'ug1.lft AND ug1.rgt' . $test . 'ug2.rgt');
		$query->join('INNER', '#__user_usergroup_map AS m ON ug2.id=m.group_id');
		$query->where('ug1.id=' . $db->Quote($groupId));

		$db->setQuery($query);

		$result = $db->loadColumn();

		// Clean up any NULL values, just in case
		JArrayHelper::toInteger($result);

		return $result;
	}
	
	public static function getEmailById($userId = array(), $disabled = 0)
	{
		//JXITODO : check userId
		$db = JXiFormsFactory::getDbo();

		$query  = new Rb_Query();

		$query->select('email');
		$query->from('#__users');

		if (empty($userId)) {
			$query->where('0');
		} else {
			$query->where('id IN (' . implode(',', $userId) . ')');
		}

		if ($disabled == 0){
			$query->where("block = 0");
		}

		$db->setQuery($query);
		$rows = $db->loadColumn();
		
		return $rows;
	}
}