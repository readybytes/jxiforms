<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionRecaptcha extends UglyformsAction
								implements UglyformsInterfaceValidator
{
	protected $_location	= __FILE__;

	public function onUglyformsLoadPosition($positions, $view)
	{
		if (in_array('uglyforms-input-display-footer', $positions)){

			if(!function_exists('recaptcha_get_html')){
				require_once('recaptchalib.php');
			}

			$use_ssl = $this->getActionParam('ssl_site', false);
			$recaptcha_html = recaptcha_get_html($this->getActionParam('public_key'), null, $use_ssl);
			
			$this->assign('recaptcha_html', $recaptcha_html);
			$this->assign('recaptcha_theme', $this->getActionParam('theme'));

			$content = $this->_render('recaptcha');
			
			return array('uglyforms-input-display-footer'=> $content);
		}
	}
	
	public function onUglyformsDataValidation(UglyformsInput $input, $data_id)
	{
		 $data 	= $this->getInputData($data_id)->data;
		
		 if(!function_exists('recaptcha_check_answer')){
			  require_once('recaptchalib.php');
		  }
		 
		 //when recaptcha element is absent from post data
		 if (!isset($data["recaptcha_challenge_field"]) || !isset($data["recaptcha_response_field"])){
			 return false;
		 }

		 $resp = recaptcha_check_answer($this->getActionParam('private_key'),
		                                $_SERVER["REMOTE_ADDR"],
		                                $data["recaptcha_challenge_field"],
		                                $data["recaptcha_response_field"]);
		
		 if (!$resp->is_valid) {
		   //die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
		    //     "(reCAPTCHA said: " . $resp->error . ")");
		    //TODO : log data for failure case
		    return false;
		 }
		 
		 return true;
	}
}
