<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');
/**
 * @author bhavya
 */

if(!class_exists('MCAPI')){
require_once dirname(dirname(__FILE__)).'/MCAPI.class.php';	
}
class JXiFormsFormFieldMailchimplist extends JFormFieldList
{	
	protected $type = 'mailchimplist';
	
	public function getOptions()
	{
		$lists = $this->getMailchimpList();
		if(empty($lists)){
			return JText::_('COM_JXIFORMS_ACTION_MAILCHIMP_NO_LIST_EXISTS_FOR_API_KEY');
		}		
		
		$options = array();
		foreach ($lists as $list){
			$options[] = JXiFormsHtml::_('select.option', $list['id'], $list['name']);
		}

		return $options;
	}
	
	function getMailchimpList()
	{  
		$lists = array();
		$actionId = JXiFormsFactory::getApplication()->input->get('id',0);
		if($actionId == 0){
			return $lists;
		}
		
		$mailChimpApp = JXiformsAction::getInstance($actionId);
		$apiKey = $mailChimpApp->getActionParam('mailchimpApikey');
		if(empty($apiKey)){
			return  $lists;
		}
		$MCAPI = new MCAPI($apiKey);
		$retval = $MCAPI->lists();
		if($retval != false){
			foreach($retval['data'] as $data){
				$id = $data['id'];
				$lists[$id] = array('id'=>$data['id'],
											 'name'=>$data['name']);
			}
		}
		return $lists;
	}
}