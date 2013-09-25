<?php

/**
* @copyright Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license GNU/GPL, see LICENSE.php
* @package JoomlaXi Forms
* @subpackage Back-end
* @contact team@readybytes.in
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
* View of Attach Action
* @author Jitendra Khatri
*/
require_once dirname(__FILE__).'/view.php';

class jxiformsadminViewInput extends JXiFormsAdminBaseViewInput
{
	public function addAction()
	{
		$actionForm 		= array();
		$actionObject 		= array();
		$xmlData			= array();
		
		// JXIF TODO: Remove this JUGAD.
		$document			= JDocument::getInstance('html');
		JFactory::$document = $document;
		
		$actionType	= JXiFormsFactory::getApplication()->input->get('event_args', '', 'ARRAY');
		$actionType = $actionType['action_type'];
		
		$enableActions 		= JXiFormsHelperAction::getXml();
		if(is_array($enableActions)
			&& array_key_exists($actionType, $enableActions))
			{
				// For getting proper XML heirarchy on Form's Object
				$actionForm[] 				= JXiFormsHelperAction::getProperXML($actionType, 0);
				$actionObject[$actionType] 	= JXiformsAction::getInstance(0, $actionType);
				$xmlData  	    			= JXiFormsHelperAction::getXml();
				$xmlData["$actionType"]		= isset($xmlData["$actionType"]) ? $xmlData["$actionType"] : '';
			}
		
		//Assigns array to be used in Template 
		$this->assign('actions',  $actionForm);
		$this->assign('actionType', $actionType);
		$this->assign('action', $actionObject);
		$this->assign('xmlData', $xmlData);
		
		$ajax 	= Rb_Factory::getAjaxResponse();

		// Prepare Output
		$ajax->addScriptCall('jxiforms.jQuery(\'#add_task_form\').append', $this->loadTemplate('add_task'));
		// Stop Ajax request and send output
		$ajax->sendResponse();
	}
	
	
	public function createMenu($args)
	{
		$menuParams	= JXiFormsFactory::getApplication()->input->get('event_args', '', 'ARRAY');

		$cmp   	=  JComponentHelper::getComponent('com_jxiforms');
		$link  	=  "index.php?option=com_jxiforms&view=input&input_id=".$menuParams['input_id'];
		
		if(!Rb_HelperJoomla::isMenuExist($link, $cmp->id))
		{
			$result =  Rb_HelperJoomla::addMenu($menuParams['menu_title'], $menuParams['menu_alias'], $link, $menuParams['parent_menu'], $cmp->id);
			$menu 	= Rb_HelperJoomla::getExistingMenu($link, $cmp->id);
		}
			
		$this->assign('form_menu', $menu);
		
		if($result === false){?>
			<script type="text/javascript">
				alert('Something got wrong while creating menu for you form');
			</script>
			<?php 
			$ajax 	= Rb_Factory::getAjaxResponse();
			$ajax->sendResponse();		
		}
		
		$ajax 	= Rb_Factory::getAjaxResponse();	
		$ajax->addScriptCall('jxiforms.jQuery(\'#menuoptions\').html', $this->loadTemplate('menu_link'));
		$ajax->sendResponse();
		
	}
	
}