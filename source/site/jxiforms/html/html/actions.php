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
class JxiformsHtmlActions
{
	function edit($name, $value, $attr=null, $ignore=array())
	{
		$actions  =  JXiFormsFactory::getInstance('action', 'model')->loadRecords();
		
		$options = array();
		
		if(isset($attr['none']))
			$options[] = JXiFormsHtml::_('select.option', '', Rb_Text::_('Select Action'));
			
		foreach($actions as $action){
			$options[] = JXiFormsHtml::_('select.option', $action->action_id, $action->title);	
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
