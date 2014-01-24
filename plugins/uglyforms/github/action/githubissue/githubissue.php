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
{
	protected $_location	= __FILE__;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		require_once dirname(dirname(__FILE__)).'/helper.php';
	}
	
	public function process($data, $attachments)
	{
		$username  	    =  $this->getActionParam('username', '');
		$password		=  $this->getActionParam('password', '');
		$organization	=  $this->getActionParam('organization', '');
		$repo			=  $this->getActionParam('repository', '');

		$owner 			=  empty($organization) ? $username : $organization;
		$url 			= "https://api.github.com/repos/$owner/$repo/issues";
		
		$issue 			= $this->_prepareIssue($data);
		$response 		= UglyformsActionGithubHelper::requestAPI($url, "POST", $username, $password, $issue);
		
		if($response['http_code'] == 201){
			//JXITODO : success log of github issue creation
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}
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

		return json_encode($issue);
	}
}
