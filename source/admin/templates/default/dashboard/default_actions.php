<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.readybytes.net
*/
	if(defined('_JEXEC')===false) die();
?>
<?php 
	JHtml::_('behavior.framework');

	if(isset($enablePlugins)){
		foreach ($enablePlugins as $type => $data){
			$imagePath  = $data['location']."/".$data['icon'];
			$imagePath  = file_exists($imagePath) ? $imagePath : UGLYFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png';
?>
		
		<div class="dashboard-icon action-icon-view jxif-padding02 center" onclick="location.href='<?php echo Rb_Route::_('index.php?option=com_uglyforms&view=action&task=new&type='.$type);?>';">
			<div class="dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $data['name']) ;?></div>
	 		<div class="dashboard-icon-name"><?php echo $data['name'];?></div>
		</div>
		
<?php 	}
	}	?>

<!-- JXITODO: Must have to move this script to js file-->
<script type="text/javascript">
	uglyforms.jQuery(document).ready(function()
		{
			uglyforms.jQuery('.jxif-disable').hover(function()
			{
					uglyforms.jQuery(this).css({"border" : "2px solid #D8D8D8" , "cursor": "default"});
					uglyforms.jQuery(this).children('.enable-plugin-button').show();
					uglyforms.jQuery(this).children('.dashboard-icon-name').hide();
			},
			function()
			{
				uglyforms.jQuery(this).children('.enable-plugin-button').hide();
				uglyforms.jQuery(this).children('.dashboard-icon-name').show();
			});
		});
</script>

<?php
	if(isset($disablePlugins)){
		foreach ($disablePlugins as $plugin)
		{
?>		
		<div class="jxif-disable dashboard-icon action-icon-view jxif-padding02 center" title="<?php echo Rb_Text::_("COM_UGLYFORMS_DASHBOARD_DISABLED_ACTION_ICON_TOOLTIP");?>">
			<div class="dashboard-icon-image jxif-opacity45"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($plugin->icon, false), $plugin->name) ;?></div>
			<div class="dashboard-icon-name jxif-opacity45"><?php echo $plugin->name;?></div>
			<div class="enable-plugin-button">
				<input type="button" value="<?php echo Rb_Text::_('COM_UGLYFORMS_DASHBOARD_ENABLE_PLUGIN_BUTTON');?>" class="btn" onclick="window.location.href='<?php echo JUri::base().'index.php?option=com_uglyforms&view=dashboard&task=enableActionPlugin&plugin='.$plugin->element.'&pluginName='.$plugin->name; ?>'"); />
			</div>
		</div>
		
<?php 	}
	}


