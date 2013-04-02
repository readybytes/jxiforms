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
class JXiFormsFormFieldGithubmilestonelist extends JFormFieldList
{	
	protected $type = 'githubmilestonelist';
	
	public function getOptions()
	{
		$milestones = $this->getGithubmilestonelist();
		if(empty($milestones)){
			return Rb_Text::_('COM_JXIFORMS_ACTION_GITHUB_NO_MILESTONE_EXISTS');
		}		
		
		$options = array();
		foreach ($milestones as $milestone){
			$options[] = JXiFormsHtml::_('select.option', $milestone['id'], $milestone['name']);
		}

		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
	
	function getGithubmilestonelist()
	{  
		$milestones  = array();
		$actionId = JXiFormsFactory::getApplication()->input->get('id',0);
		if($actionId == 0){
			return $milestones;
		}
		
		$githubApp 	= JXiformsAction::getInstance($actionId);
		$params		= $githubApp->getActionParams();
		
		$username	  = $params->get('username', '');
		$password	  = $params->get('password', '');
		$organization = $params->get('organization', '');
		$repository	  = $params->get('repository', '');
		
		$owner		  =  empty($organization) ? $username : $organization;
		$url 		  = "https://api.github.com/repos/$owner/$repository/milestones";
		//request github api to list the workspaces
		$result 	= JXiFormsActionGithubHelper::requestAPI($url, "GET", $username, $password);
		$response   = json_decode($result['body'], true);
		
		if($result['http_code'] != 200){
			return $milestones;
		}
		
		foreach ($response as $milestone){
			$milestones[$milestone['id']] = array('id'=> $milestone['number'], 'name' => $milestone['title']); 
		}
		
		return $milestones;
	}
}