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

JHtml::_('behavior.framework');
?>

<div class="row-fluid">
	<div class="span12">
		<!--For Actions Panel-->
		<div class="span7 dashboard-icon-panel jxif-left-padding01">
			<div class="span10 jxif-padding01 jxif-action-heading jxif-fontsize15 margin-top2 jxif-text-colorgray"><?php echo Rb_Text::_('COM_JXIFORMS_SUBMENU_ACTION');?></div>
			<div><?php echo  $this->loadTemplate('actions', compact('enablePlugins', 'disablePlugins')); ?></div>
		</div>
		
		<!--For BroadCast By Joomlaxi-->
		<div class="span5">
		<?php
			$version = new JVersion();
			$suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&jxif=JXIF'.JXIFORMS_VERSION.'&dom='.JURI::getInstance()->toString(array('scheme', 'host', 'port'));?>
			<div class="span12 dashboard-icon-panel">
				<iframe class="span12 jxif-padding02 jxif-border00" src="http://pub.joomlaxi.com/broadcast/broadcast.html?<?php echo $suffix?>"></iframe>

				<div class="span12">
					<!-- JXITODO: Show a Cross-Button For Permanent removing this link-->
					<h2><?php echo $howItWorks;?></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 