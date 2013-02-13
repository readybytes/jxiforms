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
		$info = curl_getinfo($ch);
				
		if($get_info){
			return array($info, $content);
		}
		
		return $content;
	}
	
	public static function sendEmailToAdmin($subject, $message, $attachments=null)
	{		
		$admins  = Rb_HelperJoomla::getUsersToSendSystemEmail();
		
		$emails = array();
		foreach ($admins as $admin){
			if ($admin->sendEmail){
				$emails[] = $admin->email;
			}
		}
		return JXiFormsHelperUtils::sendEmail($subject, $message, $attachments, $emails);
	}
	
	public function sendEmail($subject, $message, $attachments=null, $emails = array())
	{
		//when no email address exists
		if (empty($emails)){
			return true;
		}
		
		$app  		= JXiFormsFactory::getApplication();
		$mailfrom 	= $app->getCfg( 'mailfrom' );
		$fromname 	= $app->getCfg( 'fromname' );
		
		if( !$mailfrom  || !$fromname ) {
			throw new Exception(Rb_Text::_('COM_JXIFORMS_EXCEPTION_UTILS_NO_EMAILFROM_AND_FROMNAME_EXISTS'));
		}
		
		$message = html_entity_decode($message, ENT_QUOTES);
		$mail 	 = JXiFormsFactory::getMailer()->setSender( array($mailfrom, $fromname))
											   ->addRecipient(array_shift($emails))
									           ->setSubject($subject)
									           ->setBody($message);

		if($attachments != null){
			$mail->addAttachment($attachments);
		}

		
		foreach ($emails as $email){
			$mail->addBCC($email);
		}
		
		$mail->Send();
		
		return true;
	}
	
	public static function isEmailAddress($email)
	{
		// Split the email into a local and domain
		$atIndex = strrpos($email, "@");
		$domain = substr($email, $atIndex + 1);
		$local = substr($email, 0, $atIndex);

		// Check Length of domain
		$domainLen = strlen($domain);
		if ($domainLen < 1 || $domainLen > 255)
		{
			return false;
		}

		/*
		 * Check the local address
		 * We're a bit more conservative about what constitutes a "legal" address, that is, A-Za-z0-9!#$%&\'*+/=?^_`{|}~-
		 * Also, the last character in local cannot be a period ('.')
		 */
		$allowed = 'A-Za-z0-9!#&*+=?_-';
		$regex = "/^[$allowed][\.$allowed]{0,63}$/";
		if (!preg_match($regex, $local) || substr($local, -1) == '.')
		{
			return false;
		}

		// No problem if the domain looks like an IP address, ish
		$regex = '/^[0-9\.]+$/';
		if (preg_match($regex, $domain))
		{
			return true;
		}

		// Check Lengths
		$localLen = strlen($local);
		if ($localLen < 1 || $localLen > 64)
		{
			return false;
		}

		// Check the domain
		$domain_array = explode(".", rtrim($domain, '.'));
		$regex = '/^[A-Za-z0-9-]{0,63}$/';
		foreach ($domain_array as $domain)
		{

			// Must be something
			if (!$domain)
			{
				return false;
			}

			// Check for invalid characters
			if (!preg_match($regex, $domain))
			{
				return false;
			}

			// Check for a dash at the beginning of the domain
			if (strpos($domain, '-') === 0)
			{
				return false;
			}

			// Check for a dash at the end of the domain
			$length = strlen($domain) - 1;
			if (strpos($domain, '-', $length) === $length)
			{
				return false;
			}
		}

		return true;
	}
	
	static public function markExit($msg='NO_MESSAGE')
	{
		// if not already set
		if(defined('JXIFORMS_EXIT')==false){
			define('JXIFORMS_EXIT',$msg);
			return true;
		}

		//already set
		return false;
	}
}