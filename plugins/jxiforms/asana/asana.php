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
class  plgJxiformsAsana extends JXiFormsPlugin
{	
	protected $_location	= __FILE__;

    function __construct(& $subject, $config = array())
    {
        parent::__construct($subject, $config);
        
        $fileName = $this->getLocation().'/action/'.$this->_name.'task/'. $this->_name.'task.php';
		Rb_HelperLoader::addAutoLoadFile($fileName, 'JXiFormsAction'.$this->_name.'task');
		
		JXiFormsHelperAction::addAction($this->_name.'task');
    }
}



