<?php 
/**
* @copyright 		Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			Joomlaxi Forms	
* @subpackage		Frontend
* @contact 			team@readybytes.in
*/
if(defined('_JEXEC')===false) die();

abstract class JXiFormsPlugin extends Rb_Plugin
{
	public $_component	= JXIFORMS_COMPONENT_NAME;
	
	//JXITODO : remove this code
	public function onJxiformsInputSubmit($inputInstance, $data, $attachments)
	{
		$actions = JXiFormsHelperAction::getAvailableActions($this->_name);
		
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
	
	function __construct(& $subject, $config = array())
    {
        parent::__construct($subject, $config);
        
        $fileName = $this->getLocation().'/action/'.$this->_name.'/'. $this->_name.'.php';
		Rb_HelperLoader::addAutoLoadFile($fileName, 'JXiFormsAction'.$this->_name);
		
		JXiFormsHelperAction::addAction($this->_name);
    }
    
    public function getLocation()
    {
    	return dirname($this->_location);
    }
}
