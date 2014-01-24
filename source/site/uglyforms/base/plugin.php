<?php 
/**
* @copyright 		Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			Ugly Forms	
* @subpackage		Frontend
* @contact 			team@readybytes.in
*/
if(defined('_JEXEC')===false) die();

abstract class UglyformsPlugin extends Rb_Plugin
{
	public $_component	= UGLYFORMS_COMPONENT_NAME;
	
	function __construct(& $subject, $config = array())
    {
        parent::__construct($subject, $config);
        
        $fileName = $this->getLocation().'/action/'.$this->_name.'/'. $this->_name.'.php';
		Rb_HelperLoader::addAutoLoadFile($fileName, 'UglyformsAction'.$this->_name);
		
		UglyformsHelperAction::addAction($this->_name);
    }
    
    public function getLocation()
    {
    	return dirname($this->_location);
    }
}
