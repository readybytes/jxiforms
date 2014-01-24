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
class UglyformsActionHttpquery extends UglyformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$url 		       = $this->getActionParam('query_url', '');
		$queryParameters   = $this->getActionParam('query_parameters', '');
		$filters		   = $this->getActionParam('filter_parameters', '');
		
		list($info, $content) =  $this->_executeHttpQuery($url, $queryParameters, $data, $filters);
		
		//http-code 2XX This class of status codes indicates the action requested 
		//by the client was received, understood, accepted and processed successfully.
		if($info['http_code'] > 199 && $info['http_code'] < 300){
			return true;
		}
		
		return false;
	}

	protected function _executeHttpQuery($url, $query, $postedData, $filters)
	{
		$requestString  = $this->_createRequestString($url, $query, $postedData, $filters);
		
		//JXITODO: process response
		return UglyformsHelperUtils::postDataByCurl($url, $requestString, true);
	}
	
	protected function _createRequestString($url, $query, $data, $filters)
	{
		//these value needs to be removed form the posted data so that it does not create infinite loop
		$defaultFilter = array('option', 'view', 'task', 'input_id', 'Itemid');
		$filters  = explode("\r\n", $filters);			
		$filters = array_unique(array_merge($filters, $defaultFilter));
		
		$queryParameters = explode( "\r\n", $query );
		
		$queryArray = array();
		foreach ($queryParameters as $param){
			list($key, $value) = explode('=', $param);
			$queryArray[$key] = $value;
			//fetch the token and replace its value if exists in data
			if(preg_match('/\[\[(.*)\]\]/', $value, $t)){
				$queryArray[$key] = isset($data[$t[1]]) ? $data[$t[1]] : $value;
			}
		}

		$queryKey = array_keys($queryArray);
		$filters   = array_diff($filters, $queryKey);
		
		foreach ($filters as $key){
			//key may contains \r that needs to be removed for further processing 
			unset($data[trim($key)]);
		}
		
		$requestArray = ($this->getActionParam('append_data', 1)) ? array_merge($data, $queryArray) : $queryArray;
		return http_build_query($requestArray);
	}
}
