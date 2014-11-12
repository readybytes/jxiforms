<?php
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class JXiFormsModel extends Rb_Model
{
	public	$_component	= JXIFORMS_COMPONENT_NAME;
	
	public function deleteMany($condition, $glue='AND', $operator='=')
	{
		// assert if invalid condition
		Rb_Error::assert(is_array($condition), JText::_('PLG_SYSTEM_RBSL_ERROR_INVALID_CONDITION_TO_DELETE_DATA'));
		Rb_Error::assert(!empty($condition), JText::_('PLG_SYSTEM_RBSL_ERROR_INVALID_CONDITION_TO_DELETE_DATA'));

		$query = new Rb_Query();
		$query->delete()
				->from($this->getTable()->getTableName());

		foreach($condition as $key => $value)
			$query->where(" $key $operator $value", $glue);

		return $query->dbLoadQuery()->execute();
	}
}
