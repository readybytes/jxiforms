<?php
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


if(RB_REQUEST_DOCUMENT_FORMAT === 'ajax'){
	class JXiFormsViewbase extends Rb_ViewAjax{}
}elseif(RB_REQUEST_DOCUMENT_FORMAT === 'json'){
	class JXiFormsViewbase extends Rb_ViewJson{}
}else{
	class JXiFormsViewbase extends Rb_ViewHtml{}
}

class JXiFormsView extends JXiFormsViewbase 
{
	public $_component = JXIFORMS_COMPONENT_NAME;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		self::addSubmenus(array('dashboard', 'config', 'input', 'action', 'queue', 'appstore'));
		return $this;
	}
	
	protected function _showAdminFooter()
	{
		ob_start()?>
       
        <div class="powered-by">
	       <?php echo Rb_Text::_('COM_JXIFORMS_POWERED_BY') .'<a href="http://www.joomlaxi.com/products/item/joomlaxi-forms.html" target="_blank" >Joomlaxi Forms</a>';?>
		   <?php echo ' | '.Rb_Text::_('COM_JXIFORMS_FOOTER_VERSION').' <strong>'.JXIFORMS_VERSION .'</strong> | '. Rb_Text::_('COM_JXIFORMS_FOOTER_BUILD').JXIFORMS_REVISION; ?>	  	
        	<?php echo '<br />'
        		.Rb_Text::_('COM_JXIFORMS_FOOTER_MESSAGE')
        		.'<a href="http://bit.ly/WtlmW4" target="_blank">'.Rb_Text::_('COM_JXIFORMS_FOOTER_MESSAGE_JED_LINK').'</a>'
        	?>
	    </div>
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
