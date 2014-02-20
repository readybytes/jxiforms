<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsSiteBaseViewInput extends UglyformsView
{
	public function loadMultiplePosition($positions)
	{		
		$args 		= array($positions, $this);
		$refObject 	= UglyformsInput::getInstance($this->getModel()->getId());
		
		$result = UglyformsHelperEvent::trigger('onUglyformsLoadPosition', $args, '', $refObject);
		
		$final_result = array();	
		foreach ($result as $data){
			if (is_array($data)){
				foreach ($data as $position =>$content){
					$final_result[$position][] = $content;
				}
			}
		}
		
		return $final_result;
	}
}