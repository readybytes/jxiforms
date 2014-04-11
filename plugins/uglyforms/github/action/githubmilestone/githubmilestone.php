<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionGithubmilestone extends UglyformsAction
										implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		require_once dirname(dirname(__FILE__)).'/helper.php';
	}
	
	public function process($input_id, $data_id)
	{
		$data			= $this->getInputData($data_id)->data;
		
		$username  	    =  $this->getActionParam('username', '');
		$password		=  $this->getActionParam('password', '');
		$organization	=  $this->getActionParam('organization', '');
		$repo			=  $this->getActionParam('repository', '');

		$owner 			=  empty($organization) ? $username : $organization;
		$url 			= "https://api.github.com/repos/$owner/$repo/milestones";
		
		list($milestone, $milestone_json)	= $this->_prepareMilestone($data);
		$response 		= UglyformsActionGithubHelper::requestAPI($url, "POST", $username, $password, $milestone_json);
		
		if($response['http_code'] == 201){
			UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_GITHUB_MILESTONE_LOG_MILESTONE_CREATED', $milestone['title']), $this->getId(), get_class($this), $data_id);
			return true;
		}
		
		UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_GITHUB_MILESTONE_LOG_MILESTONE_CREATION_FAILED', $milestone['title'], $response['http_code']), $this->getId(), get_class($this), $data_id);
		return false;
	}
	
	protected function _prepareMilestone($data)
	{
		$milestone		  			=  array();
		$milestone['title']  		=  UglyformsHelperRewriter::rewrite($this->getActionParam('milestone_title', ''), $data);
		$milestone['description']	=  UglyformsHelperRewriter::rewrite($this->getActionParam('milestone_description', ''), $data);
		$milestone['state'] 		=  $this->getActionParam('state', '');
		$milestone['due_on']	  	=  $this->getActionParam('due_on', '');
		
		//unset empty values
		foreach ($milestone as $key => $param){
			if(empty($param)){
				unset($milestone[$key]);
			}
		}

		$milestone_json = json_encode($milestone);
		return array($milestone, $milestone_json);
	}
}
