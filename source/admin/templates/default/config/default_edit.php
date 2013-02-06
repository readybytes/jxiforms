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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select.multiselect');
?>

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo Rb_Text::_('COM_JXIFORMS_CONFIG_SETTING' ); ?> </legend>								
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('send_approval_email'); ?> </div>
				<div class="controls"><?php echo $form->getInput('send_approval_email'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('send_approval_email_to'); ?> </div>
				<div class="controls"><?php echo $form->getInput('send_approval_email_to'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('send_approval_email_group'); ?> </div>
				<div class="controls"><?php echo $form->getInput('send_approval_email_group'); ?></div>								
			</div>
			
			<?php echo $form->getInput('bucket_path'); ?>
			<?php echo $form->getInput('current_bucket'); ?>
			
		</fieldset>
	</div>
	<input type="hidden" name="task" value="save" />
</form>
<?php 
