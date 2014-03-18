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
 * Validator Interface
 * All those action which validates data must implements this interface
 * @author bhavya
 *
 */
interface UglyformsInterfaceValidator
{
	public function onUglyformsDataValidation($input, $data_id);
}