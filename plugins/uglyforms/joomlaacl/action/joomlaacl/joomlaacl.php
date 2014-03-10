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
class UglyformsActionJoomlaacl extends UglyformsAction
{
	protected $_location	= __FILE__;
	
	public function authorise($input, $user)
	{
		$access_level  		= $this->getActionParam('accesslevel', 0);		
		$authorisedLevels 	= $user->getAuthorisedViewLevels();
		
		//if user belongs to provided access-level
		if ($access_level != 0 && in_array($access_level, $authorisedLevels)){
			return true;
		}
		
		return false;		
	}
}
