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
class JXiFormsActionHttpquery extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$url 		       = $this->getActionParam('query_url', '');
		$queryParameters   = $this->getActionParam('query_parameters', '');
		$filters		   = $this->getActionParam('filter_parameters', '');
		
		return $this->_executeHttpQuery($url, $queryParameters, $data, $filters);
	}

	protected function _executeHttpQuery($url, $query, $postedData, $filters)
	{
		$requestString  = $this->_createRequestString($url, $query, $postedData, $filters);
		
		//JXITODO: process response
		return JXiFormsHelperUtils::postDataByCurl($url, $requestString);
	}
	
	protected function _createRequestString($url, $query, $data, $filters)
	{
		$filters  = explode("\n", $filters);			
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
		return http_build_query($queryArray);
	}
	
	public function showDataEditor()
	{
		return false;
	}
}
