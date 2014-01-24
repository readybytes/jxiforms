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
class UglyformsFormFieldStatus extends JFormFieldList
{
	
	protected $type = 'status';
	
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$entity   = isset($this->element['entity']) ? $this->element['entity'] : 'UglyformsQueue';
		$entities = explode(",", $entity);

		$all_status = array();
		foreach ($entities as $entity){
			$status = call_user_func(array($entity, 'getAllStatus')); 
			foreach ($status as $key => $value){
				$options[] = XiECHtml::_('select.option', $key, $value);
			}
		}
		
		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
	
}