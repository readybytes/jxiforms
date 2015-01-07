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
	public    $show_editor  = true;
	
	public function process($data, $attachments)
	{
		$actionParams = $this->getActionParams();
		
		$mailer  =  JXiFormsFactory::getMailer();
		$mailer->addRecipient($actionParams->get('email_id', ''));
		
		$subject  = $actionParams->get('email_subject', '');
		$body 	  = $this->getData();
		
		if(!empty($data)){
			$subject  = JXiFormsHelperRewriter::rewrite($subject, $data);
			$body     = JXiFormsHelperRewriter::rewrite($body, $data);
		}
		
		//if nothing is set in messgae then do nothing
		if(empty($body)){
			return false;
		}

		$mailer->setSubject($subject);
		$mailer->setBody($body);

		$mailer->IsHTML(false);

		//in case of text email format, remove all html and php tags from message content
		$body = strip_tags($body);
		$mailer->setBody($body);

		$this->_addEmailAddress($actionParams->get('send_cc',''),'addCC', $mailer);
		$this->_addEmailAddress($actionParams->get('send_bcc',''),'addBCC', $mailer);

		if ($mailer->Send() === true){
			return true;
		}
		
		return false;
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