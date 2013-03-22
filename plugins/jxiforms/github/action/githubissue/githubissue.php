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
class JXiFormsActionGithubissue extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$username  	    =  $this->getActionParam('username', '');
		$password		=  $this->getActionParam('password', '');
		$organization	=  $this->getActionParam('organization', '');
		$repo			=  $this->getActionParam('repository', '');

		$owner 			=  empty($organization) ? $username : $organization;
		$url 			= "https://api.github.com/repos/$owner/$repo/issues";
		
		$issue 			= $this->_prepareIssue($data);
		$response 		= $this->_requestAPI($url, "POST", $username, $password, $issue);
		
		if($response['http_code'] == 201){
			//JXITODO : success log of github issue creation
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}
	}
	
	protected function _requestAPI($url, $method, $username, $password, $data=array()) 
	{		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    
	    if($method == "POST"){
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    } 
	    
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);   
	    $response = curl_exec($ch);
	    
	    $header_size 		 = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
      	$result['header'] 	 = substr($response, 0, $header_size);
       	$result['body'] 	 = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
       	$result['last_url']  = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
       	
       	curl_close($ch);
	    return $result;
	}
	
	protected function _prepareIssue($data)
	{
		$issue		  			=  array();
		$issue['title']  		=  JXiFormsHelperRewriter::rewrite($this->getActionParam('issue_title', ''), $data);
		$issue['body']  		=  JXiFormsHelperRewriter::rewrite($this->getActionParam('issue_description', ''), $data);
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
