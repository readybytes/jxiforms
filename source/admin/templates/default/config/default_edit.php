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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select.multiselect');
?>

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo JText::_('COM_JXIFORMS_CONFIG_SETTING' ); ?> </legend>								
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approval_send_email'); ?> </div>
				<div class="controls"><?php echo $form->getInput('approval_send_email'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approval_send_email_to'); ?> </div>
				<div class="controls"><?php echo $form->getInput('approval_send_email_to'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approval_send_email_group'); ?> </div>
				<div class="controls"><?php echo $form->getInput('approval_send_email_group'); ?></div>								
			</div>
			
			<?php echo $form->getInput('bucket_path'); ?>
			<?php echo $form->getInput('current_bucket'); ?>
			
		</fieldset>
		
		<fieldset class="form-horizontal">
			<legend> <?php echo JText::_('COM_JXIFORMS_CONFIG_CRON_SETTING' ); ?> </legend>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('cron_run_automatic'); ?> </div>
				<div class="controls"><?php echo $form->getInput('cron_run_automatic'); ?></div>								
			</div>	
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('cron_frequency'); ?> </div>
				<div class="controls"><?php echo $form->getInput('cron_frequency'); ?></div>								
			</div>	
				
		</fieldset>
	</div>
	<input type="hidden" name="task" value="save" />
</form>
<?php 
