<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		jitendra@readybytes.in
* website		http://www.joomlaxi.com
*/

if(defined('_JEXEC')===false) die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>
<div class="control-group">
	<div class="control-label"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_AVAILABLE_MENU_ITEMS'); ?> </div>
	<div class="controls">
		<div class="control-label">
		<?php foreach ($form_menu as $menu):?>
				<div>
					<strong><?php echo JXiFormsHtml::link('index.php?option=com_menus&task=item.edit&id='.$menu->id, $menu->title); ?></strong>
					<p class="small"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADVANCE_MENU_ALIAS_LABEL').' : '.$menu->alias; ?><br>
					<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADVANCE_MENU_TYPE').' : '.$menu->menutype; ?></p>
				</div>
		<?php endforeach;?>
		</div>
	</div>
</div>
<?php 
