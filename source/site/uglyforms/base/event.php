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
class UglyformsEvent extends JEvent
{
	public function onUglyformsCron()
	{
		//process approved queue records 
		$this->processQueue();
		return true;
	}
	
	public function processQueue()
	{
		$records = UglyformsHelperQueue::getApprovedUnprocessedRecords();
		
		$before = new Rb_Date();
		$before = $before->toUnix();
		foreach ($records as $record){
			$queue = UglyformsQueue::getInstance($record->queue_id, $record);
			$queue->process();
			
			$after = new Rb_Date();
			$after = $after->toUnix();
			
			//check the max-execution time, whether another queue can be processed within the time frame or not
			$result = $this->_checkExecutionTime($before, $after);
			if($result === false){
				break;
			}
		}
		
		return true;
	}
	
	protected function _checkExecutionTime($startTime, $endTime)
	{
		$maxExecutionTime = ini_get('max_execution_time');

		if(($endTime-$startTime) > ($maxExecutionTime - (UGLYFORMS_EXECUTION_TIME_MARGIN * $maxExecutionTime)/100)){
			return false;
		}
		
		return true;
	}
}

$dispatcher = JDispatcher::getInstance();
$dispatcher->register('onUglyformsCron', 'UglyformsEvent');
