<?php
/**
* @copyright		Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license			GNU/GPL, see LICENSE.php
* @package			Ugly Forms
* @subpackage		Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class  plgUglyformsAck extends UglyformsPlugin
{	
	protected $_location	= __FILE__;
	
	function __construct(& $subject, $config = array())
    {
        parent::__construct($subject, $config);
        
	$actions = array('byemail', 'bysms');
        foreach ($actions as $action)
        {
        	$fileName = $this->getLocation().'/action/'.$this->_name.$action.'/'. $this->_name.$action.'.php';
			Rb_HelperLoader::addAutoLoadFile($fileName, 'UglyformsAction'.$this->_name.$action);
			UglyformsHelperAction::addAction($this->_name.$action);
        }
    }
}



