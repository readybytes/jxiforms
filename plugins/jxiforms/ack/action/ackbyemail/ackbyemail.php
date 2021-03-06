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
class JXiFormsActionAckbyemail extends JXiFormsAction
{
	protected $_location	= __FILE__;
	public    $show_editor  = true;
	
	public function process($data, $attachments)
	{
		$emailFields    = explode(',', $this->getActionParam('email_field', ''));
		$actionParams   = $this->getActionParams();
		
		$mailer  =  JXiFormsFactory::getMailer();
		
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
			$subject  = JXiFormsHelperRewriter::rewrite($subject, $data);
			$body     = JXiFormsHelperRewriter::rewrite($body, $data);
		}

		if(empty($body)){
			//JXITODO : create Error log, Message not set
			return false;
		}

		$mailer->setSubject($subject);
		$mailer->setBody($body);
		$mailer->IsHTML(1);

		// add attachments
		if($actionParams->get('send_attachments', '') && !empty($attachments)){
			foreach ($attachments as $name => $value){
				foreach ($value as $index =>$file){
					$extension = array_pop(explode('.', $file));
					$mailer->addAttachment(JPATH_SITE.$file, $name.'.'.$extension);
				}
			}
		}

		if ($mailer->Send() === true){
			return true;
		}
		
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
