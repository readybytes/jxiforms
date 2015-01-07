<?php

/**
* @copyright		Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			JxiForms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class  plgJxiformsGoogle extends JXiFormsPlugin
{	
	protected $_location	= __FILE__;

	function __construct(& $subject, $config = array())
   	{
        parent::__construct($subject, $config);
        
        $actions = array('spreadsheet');
        foreach ($actions as $action){
        	$fileName = $this->getLocation().'/action/'.$this->_name.$action.'/'. $this->_name.$action.'.php';
			Rb_HelperLoader::addAutoLoadFile($fileName, 'JXiFormsAction'.$this->_name.$action);
			JXiFormsHelperAction::addAction($this->_name.$action);
        }
    }
}



