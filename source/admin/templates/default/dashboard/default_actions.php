<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.joomlaxi.com
*/
	if(defined('_JEXEC')===false) die();
?>
<?php 
	JHtml::_('behavior.framework');

	foreach ($enablePlugins as $plugin){
		$imagePath  = JXIFORMS_PATH_PLUGIN."/".$plugin->element.'/action/'.$plugin->element."/".$plugin->element.".png";
		$imagePath  = file_exists($imagePath) ? $imagePath : JXIFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png';
?>
		
		<div class="dashboard-icon center" onclick="location.href='<?php echo Rb_Route::_('index.php?option=com_jxiforms&view=action&task=new&type='.$plugin->element);?>';">
			<div class="dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $plugin->name) ;?></div>
	 		<div class="dashbosrd-icon-name"><?php echo $plugin->name;?></div>
		</div>
		
<?php 	}	
	foreach ($disablePlugins as $plugin){
		$imagePath  = JXIFORMS_PATH_PLUGIN."/".$plugin->element.'/action/'.$plugin->element."/".$plugin->element.".png";
		$imagePath  = file_exists($imagePath) ? $imagePath : JXIFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png';
?>
		
		<div class="dashboard-icon center disabled-action" title="<?php echo Rb_Text::_("COM_JXIFORMS_DASHBOARD_DISABLED_ACTION_ICON_TOOLTIP");?>" onclick="location.href='<?php echo Rb_Route::_('index.php?option=com_plugins&filter_folder=jxiforms');?>'">
			<div class="icon-badge">&nbsp;&nbsp;Disable</div>
			<div class="dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $plugin->name) ;?></div>
			<div class="dashbosrd-icon-name"><?php echo $plugin->name;?></div>
		</div>
		
<?php 	}


