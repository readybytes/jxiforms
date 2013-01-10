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
class JXiFormsFormFieldAsanaworkspacelist extends JFormFieldList
{	
	protected $type = 'asanaworkspacelist';
	
	public function getOptions()
	{
		$workspaces = $this->getAsanaWorkspacelist();
		if(empty($workspaces)){
			return Rb_Text::_('COM_JXIFORMS_ACTION_ASANA_NO_WORKSPACE_EXISTS');
		}		
		
		$options = array();
		foreach ($workspaces as $workspace){
			$options[] = JXiFormsHtml::_('select.option', $workspace['id'], $workspace['name']);
		}

		return $options;
	}
	
	function getAsanaWorkspacelist()
	{  
		$workspaces  = array();
		$actionId = JXiFormsFactory::getApplication()->input->get('id',0);
		if($actionId == 0){
			return $workspaces;
		}
		
		$asanaApp 	= JXiformsAction::getInstance($actionId);
		$apikey  	= $asanaApp->getActionParam('api_key', '');
		$url 		= "https://app.asana.com/api/1.0/workspaces";
		//request asana api to list the workspaces
		$result 	= $asanaApp->requestAsana($url, "GET", $apikey);
		$response   = array_shift(json_decode($result['body'], true));
		
		foreach ($response as $key => $workspace){
			$workspaces[$workspace['id']] = array('id'=> $workspace['id'], 'name' => $workspace['name']); 
		}
		
		return $workspaces;
	}
}