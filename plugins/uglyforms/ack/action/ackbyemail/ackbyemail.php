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
class UglyformsActionAckbyemail extends UglyformsAction
								implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	protected $_show_editor  = true;
	protected $_approval_applicable = true;
	
	public function process($input_id, $data_id)
	{
		$record 	 =	$this->getInputData($data_id);
		$data		 = 	$record->data;
		$attachments = 	$record->attachment;
		
		$emailFields    = explode(',', $this->getActionParam('email_field', ''));
		$actionParams   = $this->getActionParams();
		
		$mailer  =  UglyformsFactory::getMailer();
		
		foreach ($emailFields as $email){
			$email  = trim($email);
			//if email field does not exists in data than ignore that field
			if(!empty($email) && isset($data[$email]) && !empty($data[$email])){
				$mailer->addRecipient($data[$email]);
			}
		}
		
		$subject  = $actionParams->get('subject', '');
		$body 	  = $this->getData();
		
		if(!empty($data)){
			$subject  = UglyformsHelperRewriter::rewrite($subject, $data);
			$body     = UglyformsHelperRewriter::rewrite($body, $data);
		}

		if(empty($body)){
			UglyformsHelperLog::create(Rb_Text::_('COM_UGLYFORMS_ACTION_ACK_BYEMAIL_LOG_MESSAGE_NOT_SET'), $this->getId(), get_class($this), $data_id);
			return false;
		}

		$mailer->setSubject($subject);
		$mailer->setBody($body);
		$mailer->IsHTML(1);

		// add attachments
		if(!empty($attachments) && $actionParams->get('send_attachments', '')){
			foreach ($attachments as $name => $value){
				$extension = array_pop(explode('.', $value));
				$mailer->addAttachment(JPATH_SITE.$value, $name.'.'.$extension);
			}
		}

		$result = $mailer->Send();
		if ( $result=== true){
			return true;
		}
		
		$reason  = ($result instanceof JException) ? $result->getMessage() : '';
		
		UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_ACK_BYEMAIL_LOG_MAIL_SENDING_FAILED', $reason), $this->getId(), get_class($this), $data_id);
		return false;
	}
	
	public function filterActionParams(array $data)
    {
    	$actionParams = $data['action_params'];

	    //when there is nothing set in the send_attachments then its parameter does not get posted	
		//checkbox element only get posted when its checked
    	if(!isset($data['action_params']['send_attachments'])){
    		$data['action_params']['send_attachments'] = 0;
    	}
    	
    	return parent::filterActionParams($data);
    }
}
