<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * 
 * Enter description here ...
 * @author bhavya
 *
 */
class UglyformsHtmlInputs
{
	function edit($name, $value, $attr=null, $ignore=array())
	{
		$inputs  =  UglyformsFactory::getInstance('input', 'model')->loadRecords();
		
		$options = array();
		
		if(isset($attr['none']))
			$options[] = UglyformsHtml::_('select.option', '', Rb_Text::_('Select Input'));
			
		foreach($inputs as $input){
			$options[] = UglyformsHtml::_('select.option', $input->input_id, $input->title);	
		}

		$style = '';
		if(isset($attr['multiple'])){
			$style  = 'multiple="multiple"';
			$name  .= '[]';
		}
		
		$style = isset($attr['style']) ? $style.' '.$attr['style'] : $style;
		return UglyformsHtml::_('select.genericlist', $options, $name, $style, 'value', 'text', $value);
	}
}
