<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		jitendra@readybytes.in
*/

if(defined('_JEXEC')===false) die();
?>
<div class="tabbable tabs-left">
    <ul class="nav nav-pills nav-stacked well">
    	<li class=""><a href="#jxif_prebuild_forms" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_PREBUILD_FORM')?></a></li>
    	<li><a href="#jxif_custom_forms" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_CUSTOM_FORM')?></a></li>
    </ul>
	<div class="tab-content">
		<div id="jxif_custom_forms" class="tab-pane well row-fluid">
			Cooming Soon...
		</div>
		<?php if (isset($enablePlugins)){?>
			<div id="jxif_prebuild_forms" class="tab-pane row-fluid">
			<?php if(isset($enablePlugins)){
						foreach ($enablePlugins as $type => $data){
							$imagePath  = $data['location']."/".$data['icon'];
							$imagePath  = file_exists($imagePath) ? $imagePath : JXIFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png'; ?>
							<div class="dashboard-icon action-icon-view jxif-padding02 center" onclick="location.href='<?php echo Rb_Route::_('index.php?option=com_jxiforms&view=input&task=edit&formtype='.$type);?>';">
								<div class="dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $data['name']) ;?></div>
						 		<div class="dashboard-icon-name"><?php echo $data['name'];?></div>
							</div>
			<?php		}
				   }?>
				</div>
		<?php }?>
	</div>
</div>
<?php
