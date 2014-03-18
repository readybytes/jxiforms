<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class UglyformsAdminControllerInput extends UglyformsController
{
	public function _save(array $data, $itemId=null)
	{
		// when there is no action selected in actions param then _input_actions 
		// does not get posted which results in incorrect data to bind with instance 
		$data['_input_actions']  = isset($data['_input_actions']) ?  $data['_input_actions'] : array();

		$input = parent::_save($data, $itemId);
		
		if (!$input){
			return false;
		}
		
		//compare existing html..if there is any change in html then only create a new record
		$old_html   = $input->getRecentHtml();
		
		if (isset($data['inputhtml']['html']) && strcmp($old_html, $data['inputhtml']['html']) != 0 ){
			$record['input_id']	=	$input->getId();
			$record['json']		=	$data['inputhtml']['json'];
			$record['html']		=	$data['inputhtml']['html'];
	
			$inputhtml_model = UglyformsFactory::getInstance('inputhtml', 'model');
			$inputhtml_model->save($record);
		}

		return $input;
	}
	
	public function createMenu()
	{
		$input_id 	= $this->getModel()->getId();
		$data  		= UglyformsFactory::getApplication()->input->post->get('uglyforms_form', array(), 'array');
		$advance 	= $data['advance'];
		
		$cmp   	=  JComponentHelper::getComponent('com_uglyforms');
		$link  	=  "index.php?option=com_uglyforms&view=input&input_id=".$input_id;
		$result =  Rb_HelperJoomla::addMenu($advance['menu_title'], $advance['menu_alias'], $link, $advance['menu_location'], $cmp->id);

		$url     = 'index.php?option=com_uglyforms&view=input&task=edit&input_id='.$input_id;
		$message = Rb_Text::_('COM_UGLYFORMS_INPUT_CREATE_MENU_SUCCESSFULLY');
		$type	 = 'message';
		
		if($result === false){
			$message  = Rb_Text::_('COM_UGLYFORMS_ERROR_INPUT_CREATE_MENU');
			$type	  = 'error';		
		}
		
		$this->setRedirect($url, $message, $type);
		return false;
	}
}