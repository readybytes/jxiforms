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
class JXiFormsActionAsanatask extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$apikey  	=  $this->getActionParam('api_key', '');		
		$url 		= "https://app.asana.com/api/1.0/tasks";
		
		$task 		= $this->_prepareTask($data);
		$response 	= $this->requestAsana($url, "POST", $apikey, $task);
		
		if($response['http_code'] == 201){
			//JXITODO : success log of github issue creation
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}
	}
	
	public function requestAsana($url, $method, $apiKey, $data=array()) 
	{		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    
	    if($method == "POST"){
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }
	    
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:");
	    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);   
	    curl_setopt($ch, CURLOPT_CAINFO, JPATH_SITE.'/libraries/joomla/http/transport/cacert.pem');
	    $response = curl_exec($ch);
	    
	    $header_size 		 = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
      	$result['header'] 	 = substr($response, 0, $header_size);
       	$result['body'] 	 = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
       	$result['last_url']  = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
       	
       	curl_close($ch);
	    return $result;
	}
	
	protected function _prepareTask($data)
	{
		$task 					=  array();
		$task['name']			=  JXiFormsHelperRewriter::rewrite($this->getActionParam('task_name', ''), $data);
		$task['notes']			=  JXiFormsHelperRewriter::rewrite($this->getActionParam('task_notes', ''), $data);
		$task['workspace']		=  $this->getActionParam('workspace', '');
		$task['projects']		=  $this->getActionParam('project', '');
		$task['assignee']		=  $this->getActionParam('assignee', '');

		return http_build_query(array_filter($task));
	}
	
	public function filterActionParams(array $data)
    {
    	$actionParams = $data['action_params'];

	    //when there is nothing set in the project then its parameter does not get posted	
    	if(!isset($data['action_params']['project'])){
    		$data['action_params']['project'] = array();
    	}
    	
    	return parent::filterActionParams($data);
    }
}
