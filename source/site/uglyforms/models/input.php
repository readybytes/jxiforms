<?php 
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


class UglyformsModelInput extends UglyformsModel
{
	public function delete($id=null)
	{
		if(!parent::delete($id))
		{
			$db = UglyformsFactory::getDBO();
			Rb_Error::raiseError(500, $db->getErrorMsg());
		}
			// delete input from inputaction table
	       return UglyformsFactory::getInstance('inputaction', 'model')
							 	 ->deleteMany(array('input_id' => $id));
	}
}

class UglyformsModelformInput extends UglyformsModelform { }
