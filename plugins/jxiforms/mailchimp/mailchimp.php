<?php

/**
* @copyright		Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class  plgJxiformsMailchimp extends RB_Plugin
{	
	function __construct(& $subject, $config = array())
    {
        parent::__construct($subject, $config);
        
        $fileName = __DIR__.'/action/mailchimp/mailchimp.php';
		Rb_HelperLoader::addAutoLoadFile($fileName, 'JXiFormsActionMailchimp');
	
		JXiFormsHelperAction::addAction('mailchimp');
    }

	public function onJxiformsInputSubmit($inputInstance, $data, $attachments)
	{
		$actions = JXiFormsHelperAction::getAvailableActions('mailchimp');
		
		$results = array();
		foreach ($actions as $action){
			$applicable = $action->isApplicable($inputInstance);
			if($applicable === false){
				continue;
			}
			
			$results[$action->getId()] = $action->process($data, $attachments);
		}
		
		return $results;
	}
}



