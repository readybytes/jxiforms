<?php
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


if(RB_REQUEST_DOCUMENT_FORMAT === 'ajax'){
	class UglyformsViewbase extends Rb_ViewAjax{}
}elseif(RB_REQUEST_DOCUMENT_FORMAT === 'json'){
	class UglyformsViewbase extends Rb_ViewJson{}
}else{
	class UglyformsViewbase extends Rb_ViewHtml{}
}

class UglyformsView extends UglyformsViewbase 
{
	public $_component = UGLYFORMS_COMPONENT_NAME;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		self::addSubmenus(array('dashboard', 'config', 'input', 'action', 'queue'));
		return $this;
	}
	
	protected function _showAdminFooter()
	{
		ob_start()?>
       
        <div class="powered-by">
	       <?php echo Rb_Text::_('COM_UGLYFORMS_POWERED_BY') .'<a href="http://www.readybytes.net/products/item/joomlaxi-forms.html" target="_blank" >Ugly Forms</a>';?>
		   <?php echo ' | '.Rb_Text::_('COM_UGLYFORMS_FOOTER_VERSION').' <strong>'.UGLYFORMS_VERSION .'</strong> | '. Rb_Text::_('COM_UGLYFORMS_FOOTER_BUILD').UGLYFORMS_REVISION; ?>	  	
        	<?php echo '<br />'
        		.Rb_Text::_('COM_UGLYFORMS_FOOTER_MESSAGE')
        		.'<a href="http://bit.ly/WtlmW4" target="_blank">'.Rb_Text::_('COM_UGLYFORMS_FOOTER_MESSAGE_JED_LINK').'</a>'
        	?>
	    </div>
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	public function _adminSubmenu($selMenu = 'dashboard')
	{
		$selMenu	= strtolower(JRequest::getVar('view',$selMenu));

		if($this->getTask() == 'display' || $this->getTask() == ''){
			foreach(self::$_submenus as $menu){
				Rb_HelperToolbar::addSubMenu($menu, $selMenu, $this->_component->getNameCom());
			}
		}
		
		return $this;
	}
}
