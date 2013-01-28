<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();
/**
 * @author Gaurav
 *
 */
class JXiFormsActionDbconnect extends JXiformsAction
{
	protected $_location	= __FILE__;	
	
	public function process($data, $attachments)
	{
		$data = $this->_quoteData($data);
		
		$actionParams = $this->getActionParams();
		
		$sql  = $actionParams->get('sql', '');
		if(empty($sql)){
			//JXITODO :
			return true;
		}
		
		$useDefaultDb	= $actionParams->get('use_default_db', true);
		$db 			= JXiFormsFactory::getDbo();	
		if(! $useDefaultDb){
			$options = array( 'host'		=> $actionParams->get('db_host', ''),
							  'user'		=> $actionParams->get('db_username', ''),
						  	  'password'	=> $actionParams->get('db_password', ''),
							  'database'	=> $actionParams->get('db_name', ''),
							  'prefix'		=> $actionParams->get('table_prefix', '')
							);

			//JXITODO :  JDatabase is deprecated in J3.0
			$db = JDatabase::getInstance($options);
		}
			
		$sql = JXiFormsHelperRewriter::rewrite($sql, $data);
		
		$sql = Rb_HelperPatch::_filterComments($sql);
		$queries = $db->splitSql($sql);
		foreach ($queries as $query){			
			$db->setQuery($query);
			if ( !$db->query() ) {
				//JXITODO : $db->stderr();
			}
		}
		
		return true;
	}
	
	protected function _quoteData($data)
	{
		$db = JXiFormsFactory::getDbo();
		foreach($data as $key => $value){
			if(is_array($value)){
				$value = implode(",", $value);
			}
			
			$data[$key] = $db->quote($value);
		}
		
		return $data;
	}	
}
