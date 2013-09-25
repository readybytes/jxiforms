<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */

class JxiformsHtmlActiontypes
{
	function edit($name, $value, $default, $attr=null, $ignore=array())
	{
		$actions = array_keys(JXiFormsHelperAction::getXml());
		
		$options = array();
		if(isset($attr['none']))
			$options[] = JXiFormsHtml::_('select.option', '', Rb_Text::_('COM_JXIFORMS_ACTION_SELECT_ACTION_TYPE'));
	
		
		isset($default) ? $options[] = JHTML::_('select.option', $default, JString::ucfirst($default)):"";
		foreach($actions as $action){
			if(array_key_exists($action, $ignore)){
				continue;
			}
			$options[] = JHTML::_('select.option', $action, JString::ucfirst($action));	
		}

		$style = isset($attr['style']) ? $attr['style'] : '';
		return JHTML::_('select.genericlist', $options, $name, $style, 'value', 'text', $value);
	}
}
