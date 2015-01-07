<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');
class JXiFormsFormFieldFieldmanipulator extends JFormFieldList
{
	protected $type = 'fieldmanipulator'; 
	
	function getInput()
	{
		$class = ( (string)$this->element['class'] ? (string)$this->element['class'] : 'inputbox' );
		$class = 'class="'.$class.' jxif-fieldmanipulator"';
		$options = array ();
		$fields  = array();
		
		foreach ($this->element->children() as $option)
		{
			// Only add <option /> elements.
			if ($option->getName() != 'option')
			{
				continue;
			}
			$val	   = (string) $option['value'];
			$options[] = Rb_Html::_('select.option', $val, JText::_((string) $option));
			
			// get attribute fields from each option
			$fieldsVal	= (string)$option['fields'];
			$fields[$val] = explode(',', $fieldsVal);
		}
		
		return JXiFormsHtml::_('jxiformshtml.fieldmanipulator.edit',$options, $this->value, $fields, ''.$this->name, $class, $this->group.$this->fieldname ,$this->group);
	}

}
