<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * 
 * Enter description here ...
 * @author bhavya
 *
 */
class JxiformsHtmlInputs
{
	static function edit($name, $value, $attr=null, $ignore=array())
	{
		$inputs  =  JXiFormsFactory::getInstance('input', 'model')->loadRecords();
		
		$options = array();
		
		if(isset($attr['none']))
			$options[] = JXiFormsHtml::_('select.option', '', JText::_('Select Input'));
			
		foreach($inputs as $input){
			$options[] = JXiFormsHtml::_('select.option', $input->input_id, $input->title);	
		}

		$style = '';
		if(isset($attr['multiple'])){
			$style  = 'multiple="multiple"';
			$name  .= '[]';
		}
		
		$style = isset($attr['style']) ? $style.' '.$attr['style'] : $style;
		return JXiFormsHtml::_('select.genericlist', $options, $name, $style, 'value', 'text', $value);
	}
}
