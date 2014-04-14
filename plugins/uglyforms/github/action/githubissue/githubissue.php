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
class UglyformsActionGithubissue extends UglyformsAction
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
		$url 			= "https://api.github.com/repos/$owner/$repo/issues";
		
		list($issue, $issue_json) 	= $this->_prepareIssue($data);
		$response 		= UglyformsActionGithubHelper::requestAPI($url, "POST", $username, $password, $issue_json);
		
		if($response['http_code'] == 201){
			UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_GITHUB_ISSUE_LOG_ISSUE_CREATED', $issue['title']), $this->getId(), get_class($this), $data_id, UglyformsLog::LEVEL_INFO);
			return true;
		}
		
		UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_GITHUB_ISSUE_LOG_ISSUE_CREATION_FAILED', $issue['title'], $response['http_code']), $this->getId(), get_class($this), $data_id);
		return false;
	}
	
	protected function _prepareIssue($data)
	{
		$issue		  			=  array();
		$issue['title']  		=  UglyformsHelperRewriter::rewrite($this->getActionParam('issue_title', ''), $data);
		$issue['body']  		=  UglyformsHelperRewriter::rewrite($this->getActionParam('issue_description', ''), $data);
		$issue['assignee']	 	=  $this->getActionParam('assignee', '');
		$issue['milestone']	  	=  $this->getActionParam('milestone', '');
		$labels					=  $this->getActionParam('label', '');
		$issue['labels']		=  empty($labels) ? '' : explode(',', $labels);
		
		//unset empty values
		foreach ($issue as $key => $param){
			if(empty($param)){
				unset($issue[$key]);
			}
		}

		$issue_json = json_encode($issue); 
		return array($issue, $issue_json);
	}
}
