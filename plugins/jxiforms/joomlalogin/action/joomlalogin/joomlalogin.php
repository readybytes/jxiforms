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
class JXiFormsActionJoomlalogin extends JXiformsAction
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
		if(JXiFormsHelperUtils::isEmailAddress($username)){
			$db		= JXiFormsFactory::getDBO();

			$query	= " SELECT `username` FROM `#__users` " 
			        . " WHERE `email` = '$username' "
			        ;
	
			$db->setQuery($query);
			$username =  $db->loadResult();
		}
		
		$result = JXiFormsFactory::getApplication()->login(array('username'=>$username, 'password'=>$password));
		
		if($result !== true){
			return false;
		}
		
		return true;
	}
}
