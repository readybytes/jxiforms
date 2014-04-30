<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionGooglespreadsheet extends UglyformsAction
										implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	protected $_approval_applicable = true;
	
	public function process($input_id, $data_id)
	{
		if(!class_exists('spreadsheet')){
			require_once(__DIR__.'/spreadsheet.php');
		}
		
		$data	= $this->getInputData($data_id)->data;
		
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
