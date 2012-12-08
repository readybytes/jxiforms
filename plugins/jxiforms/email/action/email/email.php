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
class JXiFormsActionEmail extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$actionParams = $this->getActionParams();
		
		$mailer  =  JXiFormsFactory::getMailer();
		$mailer->addRecipient($actionParams->get('email_id', ''));
		
		$subject  = $actionParams->get('email_subject', '');
		$body 	  = base64_decode($actionParams->get('message', ''));
		
		if(!empty($data)){
			$subject  = JXiFormsHelperRewriter::rewrite($subject, $data);
			$body     = JXiFormsHelperRewriter::rewrite($body, $data);
		}
		
		//if nothing is set in messgae then append all the form data in the message body
		if(empty($body)){
			foreach ($data as $key => $value){
				$body .= $key ." : ";
				
				if(is_array($value)){
					$body .= implode(",",$value) ."\n"; 
	            }
	            else{
	                $body .= $value."\n";
	            }
			}
		}

		$mailer->setSubject($subject);
		$mailer->setBody($body);

		$htmlFormat = $actionParams->get('email_format', 1);
		$mailer->IsHTML($htmlFormat);

		//in case of text email format, remove all html and php tags from message content
		if(!$htmlFormat){
			$body = strip_tags($body);
			$mailer->setBody($body);
		}

		$this->_addEmailAddress($actionParams->get('send_cc',''),'addCC', $mailer);
		$this->_addEmailAddress($actionParams->get('send_bcc',''),'addBCC', $mailer);

		// add attachments
		if(!empty($attachments)){
			foreach ($attachments as $attachment =>$value){
				$mailer->addAttachment($value, $attachment);
			}
		}

		return $mailer->Send();
	}
	
	public function filterActionParams(array $data)
	{
		// encode editor content
		if(isset($data['action_params']) && isset($data['action_params']['message'])){
			$data['action_params']['message'] = base64_encode($data['action_params']['message']);
		}

		return parent::filterActionParams($data);
	}

	public function _addEmailAddress($str, $function='addRecipient', $mailer)
	{
		// string is empty
		if(isset($str)==false || empty($str)){
			return false;
		}

		// explode emails
		$emails = explode(',', $str);
		return $mailer->$function($emails);
	}
}