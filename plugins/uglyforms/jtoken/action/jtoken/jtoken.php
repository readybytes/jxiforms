<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionJtoken extends UglyformsAction 
							implements UglyformsInterfaceValidator
{
	protected $_location	= __FILE__;
	
	public function onUglyformsLoadPosition($positions, $view)
	{
		$html = array();
		if (in_array('uglyforms-input-display-footer', $positions)){
			$content = JHtml::_('form.token');
			$html['uglyforms-input-display-footer'] = $content;
		}
		
		return $html;
	}
	
	public function onUglyformsDataValidation(UglyformsInput $input, $data_id)
	{
		if (JSession::checkToken()){
			return true;
		}
		
		UglyformsHelperLog::create(Rb_Text::_('COM_UGLYFORMS_VALIDATOR_ACTION_LOG_INVALID_DATA'), $this->getId(), get_class($this), $data_id);
		return false;
	}
}
