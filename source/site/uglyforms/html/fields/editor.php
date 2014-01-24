<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

JFormHelper::loadFieldClass('editor');
jimport('joomla.form.formfield');
/**
 * 
 * @author bhavya
 *
 */
class UglyformsFormFieldeditor extends JFormFieldEditor
{
	
	public  $type = 'editor';
		
	protected function getInput()
	{
		$this->value = base64_decode($this->value);
		return parent::getInput();
	}
}