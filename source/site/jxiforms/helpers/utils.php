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
class JXiFormsHelperUtils extends JXiFormsHelper
{
	public static function postDataByCurl($url, $string, $get_info = false)
	{			
		$version = urlencode('51.0');
		// Set the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		
		// Turn off the server and peer verification (TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		// Set the API operation, version, and API signature in the request.
		
		// Set the request as a POST FIELD for curl.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
		
		// do not track the handle's request string.
		curl_setopt($ch, CURLINFO_HEADER_OUT, false);
		
		// Get response from the server.
		$content = curl_exec($ch);
		
		// get info of content
		$info = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
				
		if($get_info){
			return array($info, $content);
		}
		
		return $content;
	}
}