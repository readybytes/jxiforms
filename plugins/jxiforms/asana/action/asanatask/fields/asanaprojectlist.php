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
class JXiFormsFormFieldAsanaprojectlist extends JFormFieldList
{	
	protected $type = 'asanaprojectlist';
	
	public function getOptions()
	{
		$projects = $this->getAsanaProjectlist();
		if(empty($projects)){
			return JText::_('COM_JXIFORMS_ACTION_ASANA_NO_PROJECT_EXISTS');
		}		
		
		$options = array();
		foreach ($projects as $project){
			$options[] = JXiFormsHtml::_('select.option', $project['id'], $project['name']);
		}

		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
	
	function getAsanaProjectlist()
	{  
		$projects  = array();
		$actionId = JXiFormsFactory::getApplication()->input->get('id',0);
		if($actionId == 0){
			return $projects;
		}
		
		$asanaApp 	= JXiformsAction::getInstance($actionId);
		$apikey  	= $asanaApp->getActionParam('api_key', '');
		$url 		= "https://app.asana.com/api/1.0/projects";
		//request asana api to list the projects
		$result 	= $asanaApp->requestAsana($url, "GET", $apikey);
		$response   = array_shift(json_decode($result['body'], true));
		
		foreach ($response as $key => $project){
			$projects[$project['id']] = array('id'=> $project['id'], 'name' => $project['name']); 
		}
		
		return $projects;
	}
}