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
class UglyformsActionChargifycustomer extends UglyformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{		
		$params = $this->getActionParams();
		
		$subdomain   = $params->get('subdomain');
		$apiKey      = $params->get('api_key');
		$requestData = $this->_prepareRequestData($data, $params);
		
		$url = "https://".$subdomain.".chargify.com/customers.json"; 
		
		$response = $this->requestChargify($url, "POST", $apiKey, $requestData);
		
		if($response['http_code'] == 201){
			//JXITODO : success log of customer creation in chargify
			return true;
		}
		else {
			//JXITODO : create error log
			return false;
		}
	}
	
	public function requestChargify($url, $method, $apiKey, $data=array()) 
	{		
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL,$url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    
	    if($method == "POST"){
	    	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    }
	    
	    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: '.strlen($data)));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	    curl_setopt($ch, CURLOPT_USERPWD, "$apiKey:x");
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
	
	protected function _prepareRequestData($data, $params)
	{
		$customer 		= array();
		$customer['first_name'] 	 = $data[$params->get('first_name')];
		$customer['last_name'] 		 = $data[$params->get('last_name')];
		$customer['email']  		 = $data[$params->get('email')];
		$customer['organization'] 	 = $data[$params->get('organization')];
		$customer['reference'] 		 = $data[$params->get('reference')];
		$customer['vat_number'] 	 = $data[$params->get('vat_number')];
		$customer['address'] 		 = $data[$params->get('address')];
		$customer['address_2'] 		 = $data[$params->get('address_2')];
		$customer['city']  			 = $data[$params->get('city')];
		$customer['state'] 			 = $data[$params->get('state')];
		$customer['zip'] 			 = $data[$params->get('zip')];
		$customer['country'] 		 = $data[$params->get('country')]; //country code
		$customer['phone'] 			 = $data[$params->get('phone')];

		$customerData = array('customer'=>$customer); 
		return json_encode($customerData);
	}
}
