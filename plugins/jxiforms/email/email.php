<?php

/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class  plgJxiformsEmail extends RB_Plugin
{
	function onJXiFormsSystemStart()
	{
		$dir = dirname(__FILE__).'/action';
		JXiFormsHelperAction::addActionsPath($dir);
	}
	
	public function onJxiformsInputSubmit($data, $inputInstance)
	{
		$actions = JXiFormsHelperAction::getAvailableActions('email');
		
		foreach ($actions as $action){
			$result = $action->isApplicable($inputInstance);
			if($result === false){
				continue;
			}
			
			$action->process($data);
		}
	}
}



