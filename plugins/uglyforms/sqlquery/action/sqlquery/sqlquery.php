<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();
/**
 * @author Gaurav
 *
 */
class UglyformsActionSqlquery extends UglyformsAction
								implements UglyformsInterfaceProcessor
{
	protected $_location	= __FILE__;
	protected $_approval_applicable = true;	
	
	public function process($input_id, $data_id)
	{
		$data	= $this->getInputData($data_id)->data;
		$data   = $this->_quoteData($data);
		
		$actionParams = $this->getActionParams();
		
		$sql  = $actionParams->get('sql', '');
		if(empty($sql)){
			UglyformsHelperLog::create(Rb_Text::_('COM_UGLYFORMS_ACTION_SQLQUERY_LOG_NO_SQL_QUERY'), $this->getId(), get_class($this), $data_id);
			return false;
		}
		
		$useDefaultDb	= $actionParams->get('use_default_db', true);
		$db 			= UglyformsFactory::getDbo();	
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
			
		$sql = UglyformsHelperRewriter::rewrite($sql, $data);
		
		$sql = Rb_HelperPatch::_filterComments($sql);
		$queries = $db->splitSql($sql);

		$result = true;
		foreach ($queries as $query){			
			$db->setQuery($query);
			if ( !$db->query() ) {
				$result = false;
				UglyformsHelperLog::create(Rb_Text::_('COM_UGLYFORMS_ACTION_SQLQUERY_LOG_QUERY_EXECUTION_ERROR', $query, $db->getErrorMsg()), $this->getId(), get_class($this), $data_id);
			}
		}
		
		return $result;
	}
	
	protected function _quoteData($data)
	{
		$db = UglyformsFactory::getDbo();
		foreach($data as $key => $value){
			if(is_array($value)){
				$value = implode(",", $value);
			}
			
			$data[$key] = $db->quote($value);
		}
		
		return $data;
	}	
}
