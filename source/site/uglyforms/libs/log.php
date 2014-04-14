<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsLog extends UglyformsLib
{
	protected   $log_id  	    =   0;
	protected 	$message        =   '';
	protected 	$reference_id   =   0;
	protected 	$reference_type	=	'';
	protected 	$data_id		=   0;
	protected   $level;
	protected 	$created_date;
	
	const LEVEL_DEBUG   = 0;
	const LEVEL_INFO    = 1;
	const LEVEL_NOTICE  = 2;
	const LEVEL_WARNING = 3;
	const LEVEL_ERROR   = 4;

	/**
	 * Gets the instance of UglyformsLog with provide form identifier
	 * 
	 * @param  integer  $id    Unique identifier of input entity
	 * @param  string   $type  
	 * @param  mixed    $bindData  Data to be binded with the object
	 * 
	 * @return Object UglyformsLog  Instance of UglyformsLog
	 */
	public static function getInstance($id = 0, $bindData = null)
	{
		return parent::getInstance('log', $id, $bindData);
	}
	
	/**
	 * Reset all the object properties to their default values
	 * 
	 * @return  Object UglyformsLog Instance of UglyformsLog
	 */
	function reset()
	{
		$this->level		= UglyformsLog::LEVEL_ERROR;
		$this->created_date = new Rb_Date();

		return $this;
	}
}