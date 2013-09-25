<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author Jitendra Khatri
 *
 */
class JXiFormsActionAckbysms extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		//For Getting Phone Number from html element where user has inserted.
		$recipient	= $this->getActionParam('recipient');
		$recipient  = $data[$recipient];

		//For Cross Checking Phone Number.
		if(!is_numeric($recipient) || strlen($recipient) < 10){
			$app = JXiFormsFactory::getApplication();
			$app->enqueueMessage(Rb_Text::_('COM_JXIFORMS_ACTION_ACK_BY_SMS_SMSGATEWAYHUB_INVALID_PHONE_NUMBER'));
			return false;
		}
		
		//Getting Details For sending Acknowledgement. 
		$userId		= $this->getActionParam('user_id');
		$password	= $this->getActionParam('password');
		$msg		= $this->getActionParam('message');
		$routeId	= $this->getActionParam('route_id');
		$senderId	= $this->getActionParam('sender_id');

		//For Sending Acknowledge Message
		$result = $this->_sendMessage($userId, $password, $senderId, $recipient, $msg, $routeId);
		return $result;
	}
	
	//Collects Settings of SMS Gateway and sends Message
	protected function _sendMessage($userId, $password, $senderId, $recipient, $msg, $routeId)
	{
		$date = date("Y-m-dTH:i:s",time());

		//Replaces all spaces with + sign Because spaces are not allowed in URL.
		$msg = str_replace(" ", "+", $msg);
		
		//Initializes cURL Session
		$ch = curl_init();
		//Url to send message
		$url="http://login.smsgatewayhub.com/API/WebSMS/Http/v1.0a/index.php?username=$userId&password=$password&sender=$senderId&to=$recipient&message=$msg&reqid=1&format={json|text}&route_id=$routeId&callback=&sendondate=$date";
		
		$b = curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_exec($ch);
		$result['http_code'] = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$error = curl_error($ch);
		curl_close($ch);
		
		
		//For Validation of messege sent succussefull or not
		if($result['http_code'] == 200){
			return true;
		}

		return false;
	}
	
}