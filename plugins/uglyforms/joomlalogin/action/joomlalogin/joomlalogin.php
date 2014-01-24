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
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
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
			return false;
		}
		
		return true;
	}
}
