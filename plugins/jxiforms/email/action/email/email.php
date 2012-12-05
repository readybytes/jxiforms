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
	
	public function process($data)
	{
		$actionParams = json_decode($this->getActionParams());
		
		$emailInst  =  JXiFormsFactory::getMailer();
		
		$emailInst->addRecipient($actionParams->email_id);
		
		$emailInst->setSubject($actionParams->email_subject);

		$body = base64_decode($actionParams->message)."\n";
		foreach ($data as $key => $value){
			$body .= $key ." : ";
			
			if(is_array($value)){
				$body .= implode(",",$value) ."\n"; 
            }
            else{
                $body .= $value."\n";
            }
		}

		$emailInst->setBody($body);

		$htmlFormat = $actionParams->email_format;
		$emailInst->IsHTML($htmlFormat);

		//in case of text email format, remove all html and php tags from message content
		if(!$htmlFormat){
			$body = strip_tags($body);
			$emailInst->setBody($body);
		}

		$this->_addEmailAddress($actionParams->send_cc,'addCC', $emailInst);
		$this->_addEmailAddress($actionParams->send_bcc,'addBCC', $emailInst);
		$emailSend = true;

		if($emailInst->Send()){
			$emailSend = true;
		}else
		{
			$emailSend = false;
		}
			
		return $emailSend;
	}
	
	public function collectActionParams(array $data)
	{
		// encode editor content
		if(isset($data['action_params']) && isset($data['action_params']['message'])){
			$data['action_params']['message'] = base64_encode($data['action_params']['message']);
		}

		return parent::collectActionParams($data);
	}
	
	public function _addEmailAddress($str, $function='addRecipient', $emailInst)
	{
		// string is empty
		if(isset($str)==false || empty($str)){
			return false;
		}

		// explode and add one by one
		$emails = explode(',', $str);
		$count = 0;
		foreach($emails as $email){
			// no need to get mailer, as we have just added it in sendEmail
			$emailInst->$function($email);
			$count++;
		}

		return $count;
	}
}