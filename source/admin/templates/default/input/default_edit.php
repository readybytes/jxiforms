<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.joomlaxi.com
*/

if(defined('_JEXEC')===false) die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select.multiselect');
?>
<!--Top HEADING-->
<div class="row-fluid margin-top1">
	<div class="span12 dashboard-icon-panel jxif-padding01 jxif-textcolor444 jxif-fontsize15"><strong><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_PAGE_HEADING');?></strong></div>
</div>
<div class="margin-top2 row-fluid">
	<!-- LEFT MARGIN-->
	<div class="span1">&nbsp;</div>
	<!--MAIN CONTENT-->
	<div class="span10">
		<div class="navbar">
	   		<div class="navbar-inner" style="min-height:30px;">
		   		<ul class="nav">
			   		<li class="active"><a href="#form_settings" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_BASIC_SETTINGS');?></a></li>
			   		<li class="divider-vertical" style="max-height:30px;"></li>
			   		<li><a href="#create_form" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_FORM');?></a></li>
			   		<li class="divider-vertical" style="max-height:30px;"></li>
			   		<li><a href="#add_task" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_ASSIGN_ACTION');?></a></li>
		   		</ul>
	   		</div>
	   	</div>
	
		<form method="post" name="adminForm" id="adminForm" action="<?php echo JUri::base().'index.php?option=com_jxiforms&view=input&task=new&type='.$type;?>">
			<div class="tab-content">
				<div class="tab-pane active margin-top1" id="form_settings">
					<?php echo $this->loadTemplate('form_settings');?>
				</div>
				<div class="tab-pane" id="create_form">
					<?php echo $this->loadTemplate('create_form');?>
				</div>
				<div class="tab-pane" id="add_task">
					<?php echo $this->loadTemplate('add_task');?>
				</div>
			</div>
		</form>
	</div>
	<!-- RIGHT MARGIN-->
	<div class="span1">&nbsp;</div>
</div>
<?php 