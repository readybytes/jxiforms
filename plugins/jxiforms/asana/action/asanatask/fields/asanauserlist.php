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
class JXiFormsFormFieldAsanauserlist extends JFormFieldList
{	
	protected $type = 'asanauserlist';
	
	public function getOptions()
	{
		$users = $this->getAsanaUserlist();
		if(empty($users)){
			return JText::_('COM_JXIFORMS_ACTION_ASANA_NO_USER_EXISTS');
		}		
		
		$options = array();
		foreach ($users as $user){
			$options[] = JXiFormsHtml::_('select.option', $user['id'], $user['name']);
		}

		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
	
	function getAsanaUserlist()
	{  
		$users  = array();
		$actionId = JXiFormsFactory::getApplication()->input->get('id',0);
		if($actionId == 0){
			return $users;
		}
		
		$asanaApp 	= JXiformsAction::getInstance($actionId);
		$apikey  	= $asanaApp->getActionParam('api_key', '');
		$url 		= "https://app.asana.com/api/1.0/users";
		//request asana api to list the users
		$result 	= $asanaApp->requestAsana($url, "GET", $apikey);
		$response   = array_shift(json_decode($result['body'], true));
		
		foreach ($response as $key => $user){
			$users[$user['id']] = array('id'=> $user['id'], 'name' => $user['name']); 
		}
		
		return $users;
	}
}