<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Reset-Password-Action
*/
if(defined('_JEXEC')===false) die();

/**
 * @author Jitendra Khatri
 *
 */
class JXiFormsActionResetPassword extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		//Process Request of Reset Password
		return $this->_processResetRequest($data);
	}
	
	//For Processing Request of Reset Password.
	protected  function _processResetRequest($data)
	{
		$app		= JXiFormsFactory::getApplication();
		$emailField = $this->getActionParam('email', '');
		$config		= JXiFormsFactory::getConfig();

		$filter = array('`email`='."'$data[$emailField]'");
		$users = JXiFormsHelperJoomla::getUser($filter);
		$user = array_shift($users);

			// Check for a user.
		if (empty($user->id)) {
			$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_INVALID_EMAIL'), 'error');
			return false;
		}

		// Get the user object.
		$user = JXiFormsFactory::getUser($user->id);

		// Make sure the user isn't blocked.
		if ($user->block) {
			$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_USER_BLOCKED'), 'error');
			return false;
		}

		// Make sure the user isn't a Super Admin.
		if ($user->authorise('core.admin')) {
			$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_SUPERADMIN_ERROR'), 'error');
			return false;
		}
		
		//Gets All data.
		$data = $this->_getEmailData($user, $data);
		
		// Set the confirmation token.
		$user->activation = $data['hashedToken'];

		// Save the user to the database.
		if (!$user->save(true)) {
			$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_USER_SAVE_FAILED', $user->getError()), 'error');
			return false;
		}

		//Prepares Contents for mail
		$subject = JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_MAIL_SUBJECT',$data['sitename']);
		$body 	 = JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_MAIL_BODY',$data['sitename'],$data['token'],$data['link_text']);

		// Send the password reset request email.
		$return = JXiFormsHelperUtils::sendEmail($subject, $body, null, array($user->email));
		// Check for an error.
		if ($return !== true) {
			$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_MAIL_SENDING_FAILED'),'error');
			return false;
		}

		$app->enqueueMessage(JText::sprintf('COM_JXIFORMS_RESET_PASSWORD_MAIL_SENDING_SUCCESSFUL'), 'Info');
		return true;
	}
	
	protected function _getEmailData($user, $data)
	{	
		//Prepares confirmation Tocken 
		$token				 = JXiFormsFactory::getApplication()->getHash(JUserHelper::genRandomPassword());
		$salt				 = JUserHelper::getSalt('crypt-md5');
		$data['hashedToken'] = md5($token.$salt).':'.$salt;
		
		//Gets Configuration of Site
		$config				 = JXiFormsFactory::getConfig();
		
		// Assemble the password reset confirmation link.
		$mode 				 = $config->get('force_ssl', 0) == 2 ? 1 : -1;
		$link 				 = 'index.php?option=com_users&view=reset&layout=confirm';
		
		// Put together the email template data.
		$data[] 			 = $user->getProperties();
		$data['fromname']	 = $config->get('fromname');
		$data['mailfrom']	 = $config->get('mailfrom');
		$data['sitename']	 = $config->get('sitename');
		$data['link_text']	 = Rb_Route::_($link, false, $mode);
		$data['link_html']	 = Rb_Route::_($link, true, $mode);
		$data['token']		 = $token;
		return $data;
	}

}
