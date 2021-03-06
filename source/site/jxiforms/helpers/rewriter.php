<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsHelperRewriter extends JXiFormsHelper
{
	public static function rewrite($content, $data)
	{	
		foreach($data as $key => $value){
			if(!is_array($value)){
				$content =  preg_replace('/\[\['.$key.'\]\]/', $value, $content);
			}
		}
		
		return $content;
	}
}