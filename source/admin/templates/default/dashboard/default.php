<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
* website		http://www.readybytes.net
*/
if(defined('_JEXEC')===false) die();

JHtml::_('behavior.framework');
?>

<div class="row-fluid">
	<div class="span12">
		<!--For Actions Panel-->
		<div class="span7 dashboard-icon-panel jxif-left-padding01">
			<div class="span10 jxif-padding01 jxif-action-heading jxif-fontsize15 margin-top2 jxif-text-colorgray"><?php echo Rb_Text::_('COM_JXIFORMS_SUBMENU_ACTION');?></div>
			<div><?php echo  $this->loadTemplate('actions', compact('enablePlugins', 'disablePlugins')); ?></div>
		</div>
		
		<!--For BroadCast-->
		<div class="span5">
			<div class="span12 dashboard-icon-panel">
				<iframe class="span12 jxif-padding02 jxif-border00" height="325px;" src="http://www.readybytes.net/broadcast/jxiforms.html"></iframe>
				<div class="span12">
					<!-- JXITODO: Show a Cross-Button For Permanent removing this link-->
					<h2><?php echo $howItWorks;?></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
