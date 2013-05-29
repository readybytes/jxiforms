<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsActionHubspotcontacts extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{		
		$params   = $this->getActionParams();
		$apiKey	  = $params->get('api_key');
		
		$contact  = $this->_prepareContact($data, $params);
		$endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey='.$apiKey;
		
		$response = $this->requestHubspot($endpoint, $contact);
		
		if($response['http_code'] == 200){
			//JXITODO : success log of contact creation in hubspot
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}	
	}
	
	public function requestHubspot($url, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_CAINFO, JPATH_SITE.'/libraries/joomla/http/transport/cacert.pem');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		
		$header_size 		 = curl_getinfo($ch,CURLINFO_HEADER_SIZE);
      	$result['header'] 	 = substr($response, 0, $header_size);
       	$result['body'] 	 = substr( $response, $header_size );
        $result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
       	$result['last_url']  = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
       	
       	curl_close($ch);
       	return $result;
	}
	
	protected function _prepareContact($data, $params)
	{	
		$param = $params->toArray();
		unset($param['api_key']);
		
		//filter empty values otherwise it will create issue in contact creation 
		$param = array_filter($param);
		
		$properties = array();
		foreach ($param as $key => $value){
			//null value results incorrect information of contact so ignore those in request
			if(isset($data[$value]) && !empty($data[$value])){
				$properties[] = array('property'=>$key, 'value'=>$data[$value]);
			}
		}
		
		$contactData = array('properties'=>$properties);
		return json_encode($contactData);
	}
}
