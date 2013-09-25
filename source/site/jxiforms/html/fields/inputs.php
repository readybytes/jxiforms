<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();


JFormHelper::loadFieldClass('list');
jimport('joomla.form.formfield');
/**
 * @author bhavya
 */
class JXiFormsFormFieldInputs extends JFormFieldList
{
	
	protected $type = 'inputs';
		
	public function getOptions()
	{
		$inputs = JXiFormsFactory::getInstance('input', 'model')->loadRecords();
		
		$options = array();
		foreach ($inputs as $input){
			$options[] = JXiFormsHtml::_('select.option', $input->input_id, $input->title);
		}
		
		return $options;
	}
	
}