<?php
/**
* @copyright		Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			JoomlaXi Forms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsActionGithubHelper extends JXiFormsHelper
{
	public static function requestAPI($url, $method, $username, $password, $data=array()) 
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
}