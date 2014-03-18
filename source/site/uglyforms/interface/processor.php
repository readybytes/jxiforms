<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		team@readybytes.in
*/

if(defined('_JEXEC')===false) die();

/**
 * Processor interface
 * All data-processing action must implement this interface
 * @author bhavya
 *
 */
interface UglyformsInterfaceProcessor
{
	function process($refId, $data_id);
}