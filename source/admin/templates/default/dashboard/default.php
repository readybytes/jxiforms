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
		<div class="span7 dashboard-icon-panel">
			<div class="span12">
				<?php echo  $this->loadTemplate('actions', compact('enablePlugins', 'disablePlugins')); ?>
			</div>
		</div>
		<div class="span5">
			<div class="span12 dashboard-icon-panel">
				<!-- JXITODO: Tracking on G-Analytics-->
				<iframe class="span12 jxif-padding02 jxif-border00" src="http://pub.joomlaxi.com/broadcast/broadcast.html"></iframe>

				<div class="span12">
					<!-- JXITODO: Show a Cross-Button For Permanent removing this link-->
					<h2><?php echo $howItWorks;?></h2>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 