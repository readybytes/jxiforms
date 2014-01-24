<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');
/**
 * @author bhavya
 */
class UglyformsFormFieldActions extends JFormFieldList
{
	
	protected $type = 'actions';
	
	public function getOptions()
	{
		$actions = UglyformsFactory::getInstance('action', 'model')->loadRecords();
		
		$options = array();
		foreach ($actions as $action){
			$options[] = UglyformsHtml::_('select.option', $action->action_id, $action->title);
		}
		
		return $options;
	}
	
}