<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsActionGithubmilestone extends JXiformsAction
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
		$url 			= "https://api.github.com/repos/$owner/$repo/milestones";
		
		$issue 			= $this->_prepareMilestone($data);
		$response 		= JXiFormsActionGithubHelper::requestAPI($url, "POST", $username, $password, $issue);
		
		if($response['http_code'] == 201){
			//JXITODO : success log of github milestone creation
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}
	}
	
	protected function _prepareMilestone($data)
	{
		$milestone		  			=  array();
		$milestone['title']  		=  JXiFormsHelperRewriter::rewrite($this->getActionParam('milestone_title', ''), $data);
		$milestone['description']	=  JXiFormsHelperRewriter::rewrite($this->getActionParam('milestone_description', ''), $data);
		$milestone['state'] 		=  $this->getActionParam('state', '');
		$milestone['due_on']	  	=  $this->getActionParam('due_on', '');
		
		//unset empty values
		foreach ($milestone as $key => $param){
			if(empty($param)){
				unset($milestone[$key]);
			}
		}

		return json_encode($milestone);
	}
}
