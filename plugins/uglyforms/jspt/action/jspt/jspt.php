<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();
/**
 * @author Jitendra Khatri
 *
 */
class UglyformsActionJspt extends UglyformsAction
							implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	protected $_approval_applicable = true;
	
	public function process($input_id, $data_id)
	{		
		$data = $this->getInputData($data_id)->data;
		return $this->_changeProfileType($data);
	}
	
	//For changing profile type of a user
	protected function  _changeProfileType($data)
	{
		//Path of JSPT's API. Must ensure JSPT and JomSocial are installed and enabled
		$pathForApi = JPATH_SITE."/components/com_xipt/api.xipt.php";
		if(!file_exists($pathForApi))
		{
			return false;
		}
		//Includes API of JSPT if class not exists
		if(!class_exists('XiptAPI'))
		{
			require_once $pathForApi;
		}
		$fieldNameForPT = $this->getActionParam('profile_type_id');
		$jsptApi	 = new XiptAPI();
		$profileType = $data["$fieldNameForPT"];
		
		//Changes Profile type and return true on success else return false
		return $jsptApi->setUserProfiletype($data['user_id'], $profileType);
	}
}
