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
class UglyformsActionJoomlalogin extends UglyformsAction
									implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	
	public function process($input_id, $data_id)
	{
		$data 		=  $this->getInputData($data_id)->data;
		
		$username	=  $this->getActionParam('username', '');
		$password	=  $this->getActionParam('password', '');
		
		$username	=  isset($data[$username]) ? $data[$username] : '';
		$password	=  isset($data[$password]) ? $data[$password] : '';
		
		return $this->_login($username, $password);
	}
	
	function _login($username, $password)
	{
		if(UglyformsHelperUtils::isEmailAddress($username)){
			$db		= UglyformsFactory::getDBO();

			$query	= " SELECT `username` FROM `#__users` " 
			        . " WHERE `email` = '$username' "
			        ;
	
			$db->setQuery($query);
			$username =  $db->loadResult();
		}
		
		$result = UglyformsFactory::getApplication()->login(array('username'=>$username, 'password'=>$password));
		
		if($result !== true){
			UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_JOOMLALOGIN_LOG_USER_LOGIN_ERROR', $username), $this->getId(), get_class($this), $data_id);
			return false;
		}
		
		UglyformsHelperLog::create(Rb_Text::sprintf('COM_UGLYFORMS_ACTION_JOOMLALOGIN_LOG_USER_LOGIN_SUCCESS', $username), $this->getId(), get_class($this), $data_id, UglyformsLog::LEVEL_INFO);
		return true;
	}
}
