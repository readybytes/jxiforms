<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionHubspotcontacts extends UglyformsAction
										implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	
	public function process($input_id, $data_id)
	{		
		$params   = $this->getActionParams();
		$apiKey	  = $params->get('api_key');
		
		$data 	  = $this->getInputData($data_id)->data;
		
		list($contact, $contact_json)  = $this->_prepareContact($data, $params);
		$endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey='.$apiKey;
		
		$response = $this->requestHubspot($endpoint, $contact_json);
		
		if($response['http_code'] == 200){
			UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_HUBSPOTCONTACTS_LOG_CONTACT_CREATED', $contact['email']), $this->getId(), get_class($this), $data_id, UglyformsLog::LEVEL_INFO);
			return true;
		}
		
		UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_HUBSPOTCONTACTS_LOG_CONTACT_CREATION_FAILED', $contact['email']), $this->getId(), get_class($this), $data_id);
		return false;
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
		$contact_json = json_encode($contactData);
		 
		return array($param, $contact_json);
	}
}