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
class JXiFormsActionGooglespreadsheet extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		if(!class_exists('spreadsheet')){
			require_once(__DIR__.'/spreadsheet.php');
		}
		
		$params = $this->getActionParams();
		$username = $params->get('email');
		$password = $params->get('password');
		$title = $params->get('spreadsheet_title');
		
		$doc = new spreadsheet();
		$doc->authenticate($username, $password);
		$doc->setSpreadsheet($title);

		$column = $params->get('column');
		$index = $column->title;
		$value = $column->value;
		
		$row = array();
		foreach ($index as $key=>$val){
			$row[$val] = $data[$value[$key]];
		}
		
		$doc->add($row);
		return true;
	}
}
