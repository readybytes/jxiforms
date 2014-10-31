<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();
/**
 * @author bhavya
 *
 */
class JXiFormsActionEmailpro extends JXiformsAction
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
		
		//if nothing is set in message do nothing
		if(empty($body)){
			return false;
		}
		
		//append all the form data in the message body
		if($actionParams->get('attach_data', 0)){
			$body .= $this->_setDefaultContent($data);
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
		if($actionParams->get('send_attachments', 0) && !empty($attachments)){
			foreach ($attachments as $attachment =>$value){
				foreach ($value as $index =>$file){
					$extension = array_pop(explode('.', $file));
					$mailer->addAttachment(JPATH_SITE.$file, $attachment.'.'.$extension);
				}
			}
		}

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
	
	protected function _setDefaultContent($data)
	{ 
		$body = '';
		
		//filter these values otherwise it will get attached with the email content
		$filter = array('option', 'view', 'task', 'input_id', 'Itemid');
		foreach ($filter as $key){
			unset($data[$key]);
		}
		
		foreach ($data as $key => $value){
			$body .= $key ." : ";
			
			if(is_array($value)){
				$body .= implode(",",$value) ."<br/>"; 
            }
            else{
                $body .= $value."<br/>";
            }
		}
		
		return $body;
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
