<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
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
class JXiFormsFormFieldJusergroups extends JFormFieldList
{
	
	protected $type = 'jusergroups';
		
	public function getOptions()
	{
		$usergroups = Rb_HelperJoomla::getJoomlaGroups();
		$options = array();
		foreach ($usergroups as $usergroup){
			$options[] = JXiFormsHtml::_('select.option', $usergroup->value, $usergroup->name);
		}
		
		return $options;
	}
	
}