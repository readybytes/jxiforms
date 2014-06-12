<?php /**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JxiForms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.joomlaxi.com
*/

if(defined('_JEXEC')===false) die();

?>
	<div class="span12 jxif-text-right" style="border-bottom:1px solid #E1E1DF;">
		<div>
			<img alt ="<?php echo Rb_Text::_('COM_JXIFORMS_FORM_POST_URL_HELP_ALTERNATE_TEXT');?>" src="<?php echo $help_image;?>" >
		</div>
		<div class="span12">
				<a href="http://www.joomlaxi.com/support/documentation/item/forms.html" target="_blank"><?php echo Rb_Text::_('COM_JXIFORMS_FORM_POST_URL_HELP_READ_MORE');?></a>
		</div>
	</div>

	<div class="span12 center">
		<div class="jxif-fontsize15 jxif-padding03" style="color:#333;"><?php echo Rb_Text::_('COM_JXIFORMS_FORM_POST_URL_HELP_CONTENT');?></div>
		<input type="button" value="<?php echo Rb_Text::_('COM_JXIFORMS_FORM_OK_BUTTON');?>" class="btn btn-success jxif-width100 jxif-fontsize15" onclick="window.parent.SqueezeBox.close();"/>
			
	</div>
<?php 