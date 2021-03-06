<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();
/**
 * @author Gaurav
 */
class JXiFormsActionJoomlaregistration extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		$actionParams = $this->getActionParams();
		
		$email 			= $actionParams->get('email', '');
		$confirm_email	= $actionParams->get('confirm_email', '');
		$name 			= $actionParams->get('name', '');
		$username 		= $actionParams->get('username', '');
		$password 		= $actionParams->get('password', '');
		$retype_password= $actionParams->get('retype_password', '');
				
		$email 			= isset($data[$email]) ? trim($data[$email])   : '';
		$confirm_email	= isset($data[$confirm_email]) ? trim($data[$confirm_email]) : '';
		$username 		= isset($data[$username]) ? trim($data[$username]) : '';
		$name 			= isset($data[$name]) ? trim($data[$name]) : '';

		if(!empty($password)){
			$password = isset($data[$password]) ? trim($data[$password]) : '';	
		}
		else{
			jimport('joomla.user.helper');
			$password = JUserHelper::genRandomPassword(); 
		}
		
		if(!empty($retype_password)){
			$retype_password 	= isset($data[$retype_password]) ? trim($data[$retype_password]) : '';
		}
		else{
			$retype_password = $password;
		}
		
//		
//		if(empty($email)){
//			// log error
//			return false;
//		}
//		
		if(empty($confirm_email)){
			$confirm_email = $email;
		}
		
		if(empty($username)){
			$username = $email;
		}		
		
		if(empty($name)){
			$name = $username;
		}
		
		$requestData = array(	'username'	=> $username,
								'name'		=> $name,
								'email1'	=> $email,
								'email2'	=> $confirm_email,
								'password1' => $password, 
								'password2' => $retype_password);
		
		$app = JXiFormsFactory::getApplication();
		require_once  JPATH_SITE.'/components/com_users/models/registration.php';
		$filename = 'com_users';
		$language = JFactory::getLanguage();
		$language->load($filename, JPATH_SITE);
		$model	= new UsersModelRegistration();
			
		JForm::addFormPath(JPATH_SITE.'/components/com_users/models/forms');
		JForm::addFieldPath(JPATH_SITE.'/components/com_users/models/fields');
		$form	= $model->getForm();
		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}
		$data	= $model->validate($form, $requestData);

		// Check for validation errors.
		if ($data === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
		}
		
		$reg_data	= $model->validate($form, $requestData);

		// Check for validation errors.
		if ($reg_data === false) {
			//JXITODO : log error
			$errors	= $model->getErrors();
			return false;
		}

		// Attempt to save the data.
		$return	= $model->register($reg_data);

		// Check for errors.
		if ($return === false) {
			//JXITODO : log error JText::sprintf('COM_USERS_REGISTRATION_SAVE_FAILED', $model->getError())
			return false;
		}

		return true;		
	}
}
