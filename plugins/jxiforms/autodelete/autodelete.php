<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Payplans
* @contact		bhavya@readybytes.in
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Payplans 
 */
class plgJxiformsAutodelete extends JXiFormsPlugin
{
	protected $_location	= __FILE__;
	
	public function onJxiformsCron()
	{ 
		$status = $this->params->get('queue_status', 0);
		$time	= trim($this->params->get('created_time', '000000000000'));
		
		if($time == '000000000000'){
			return true;
		}
		
		return $this->_autoDeleteQueueRecords($time, $status);
		 
	}
	
	protected function _autoDeleteQueueRecords($time, $status)
	{
		$currentDate	= new Rb_Date('now');
		$currentDate->alter($time, 'sub');
		
		$db = JXiFormsFactory::getDbo();
		$query = new Rb_Query();
		
		$query->delete()
			  ->from($db->quoteName('#__jxiforms_queue'))
			  ->where($db->quoteName('created_date'). ' < '. $db->quote($currentDate->toSql()), 'AND')
			  ->where($db->quoteName('status').' = '. $db->quote($status));

		$db->setQuery($query);
		$db->execute();
	
		return true;
	}
}
