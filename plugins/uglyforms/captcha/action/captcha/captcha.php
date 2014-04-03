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
class UglyformsActionCaptcha extends UglyformsAction
							 implements UglyformsInterfaceValidator
{
	protected $_location	= __FILE__;

	public function onUglyformsLoadPosition($positions, $view)
	{
		if (in_array('uglyforms-input-display-footer', $positions)){
			if(!class_exists("KCAPTCHA")){
				require_once dirname(__FILE__).'/kcaptcha/kcaptcha.php';
			}
			
			// Get Captcha
			$captcha = new KCAPTCHA();
			$key_string = $captcha->getKeyString();
			$image_src = $captcha->getImage();

			$this->assign('image_src', Rb_HelperTemplate::mediaURI($image_src, false));  
			$this->assign('action_id', $this->action_id);

			$content = $this->_render('captcha');
			
			//TODO : remove captcha images saved in media either on cron event or on 
			
			// maitain Captcha string in Session
			$session = UglyformsFactory::getSession();
			$session->set('captcha_keystring_'.$this->action_id, $key_string);
			return array('uglyforms-input-display-footer'=> $content);
		}

	}
	
	public function onUglyformsDataValidation(UglyformsInput $input, $data_id)
	{
		$data 			= $this->getInputData($data_id)->data;
		$session 		= UglyformsFactory::getSession();
		$captcha_string = $session->get('captcha_keystring_'.$this->action_id, '');
		
		//check captcha value set in the session with the user-filled data
		//desired index must exist in data if captcha action is applicable
		//non-existence implies removal of this field which tends to make this submission invalid
		if ( !isset($data['uglyforms_captcha_'.$this->action_id]) 
				|| (isset($data['uglyforms_captcha_'.$this->action_id]) 
					&& $data['uglyforms_captcha_'.$this->action_id] != $captcha_string)){
			
			//TODO : log data for failure case
			return false;
		}
		
		return true;
	}
}
