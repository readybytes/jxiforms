<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

class JXiFormsAdminBaseViewInput extends JXiFormsView
{
	function edit($tpl= null, $itemId = null)
	{
		$itemId  =  ($itemId === null) ? $this->getModel()->getState('id') : $itemId ;
		
		$input   =  JXiformsInput::getInstance($itemId);
		
		$this->assign('input', $input);
		$this->assign('form',  $input->getModelform()->getForm($input));
		
		$this->assign('preview_link', $this->_getPreviewLink($input));
		
		return true;
	} 
	
	function _getPreviewLink($input)
	{
		$preview_link = JUri::root()."index.php?option=com_jxiforms&view=input&task=display&input_id=".$input->getId()."&tmpl=component";
		
        JHTML::_('behavior.modal', "a.exportPopup");
        $buttonMap = new JObject();
        $buttonMap->set('modal', true);
        $buttonMap->set('text', Rb_Text::_('COM_JXIFORMS_INPUT_HTML_PREVIEW'));
        $buttonMap->set('modalname', 'exportPopup');
        $buttonMap->set('options', "{handler: 'iframe', size: {x: 600, y:380}}");
        $buttonMap->set('link', $preview_link);

        $previewhtml = '<a style="font-size:12px;font-weight:bold;position:relative; top:14px;"
                    id="'.$buttonMap->modalname.'" '
                 .' class="'.$buttonMap->modalname.'" '
                 .' title="'.$buttonMap->text.'" '
                 .' href ="'.$buttonMap->link.'" '
                 .' rel  ="'.$buttonMap->options.'" >'
			                .$buttonMap->text.' </a>';
	
		return $previewhtml;
	}
}