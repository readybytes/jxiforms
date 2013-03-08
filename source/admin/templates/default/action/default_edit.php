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
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select.multiselect');
?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>
<div class="row-fluid">
<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo $help['name'].Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_DETAILS' ); ?> </legend>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('title'); ?> </div>
				<div class="controls">
					<div><?php echo $form->getInput('title'); ?></div>
					<div class="clr"></div>	
					<div class="btn-link" onClick="jxiforms.utils.toggle('action-description');"><?php echo Rb_Text::_('Add a description'); ?></div>
				</div>
			</div>
			
			<div class="control-group hide" id="action-description">
				<div class="controls"><?php echo $form->getInput('description'); ?></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('published'); ?> </div>
				<div class="controls"><?php echo $form->getInput('published'); ?></div>								
			</div>
<!-- 
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('for_all_inputs'); ?> </div>
				<div class="controls"><?php echo $form->getInput('for_all_inputs'); ?></div>								
			</div>
 -->			

		 	<div class="control-group">
				<div class="control-label">
					<label class="hasTip" title="<?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_INPUTS_DESC');?>"><?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_INPUTS'); ?></label>
				</div>
				<div class="controls"><?php $inputs = $action->getInputs();
					 						echo JXiFormsHtml::_('jxiformshtml.inputs.edit', 'jxiforms_form[_action_inputs]', $inputs, array('multiple'=>true, 'style'=>"class='multiselect'"));?></div>				
			</div>
					
			<?php echo $form->getInput('action_id'); ?>
			<?php echo $form->getInput('type'); ?>
			
		<?php $fieldSets = $form->getFieldsets('core_params'); ?>
		<?php foreach ($fieldSets as $name => $fieldSet) : ?>
		
			<?php foreach ($form->getFieldset($name) as $field):?>
				<div class="control-group">
					<div class="control-label"><?php echo $field->label; ?> </div>
					<div class="controls"><?php echo $field->input; ?></div>								
				</div>
			<?php endforeach;?>
		<?php endforeach;?>
		</fieldset>	
	</div>
	
	<div class="span6">
	<fieldset class="form-horizontal">
	<legend> <?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_PARAMETERS' ); ?> </legend>
	
		<?php $fieldSets = $form->getFieldsets('action_params'); ?>
		<?php foreach ($fieldSets as $name => $fieldSet) : ?>
		
			<?php foreach ($form->getFieldset($name) as $field):?>
				<div class="control-group">
					<div class="control-label"><?php echo $field->label; ?> </div>
					<div class="controls"><?php echo $field->input; ?></div>								
				</div>
			<?php endforeach;?>
		<?php endforeach;?>	

		<?php if($action->show_editor):?>
			<div class="control-group">
					<div class="control-label"><?php echo $form->getLabel('data'); ?> </div>
					<div class="controls"><?php echo $form->getInput('data'); ?></div>
			</div>
		<?php endif;?>
		
		
	</fieldset>	
	</div>
	<div style="clear:both;"></div>
	<!-- Display help message and code block -->
	<?php if(!empty($help['help']) || !empty($help['code'])): ?>
			<fieldset class="form-horizontal">
				<legend > <?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_ACTION_HELP'); ?></legend>
					<div class="row-fluid">
					<?php if(!empty($help['help']) || !empty($help['description'])):?>
						<div class="span6">
						  <div><?php echo (isset($help['description']) && !empty($help['description'])) ? Rb_Text::_('COM_JXIFORMS_ACTION_INTRODUCTION').$help['description'] : ''; ?></div>
						  <div><?php echo (isset($help['help']) && !empty($help['help'])) ? Rb_Text::_($help['help']) : ''; ?></div>
						</div>
					<?php endif;?>
					
					<?php if(!empty($help['code'])):?>
					<div class="span6">
						<div><?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EXAMPLE_CODE'); ?></div>
						<div><?php echo $help['code']; ?></div>
					</div>
					<?php endif;?>
					</div>
		</fieldset>	
	<?php endif;?>

	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="boxchecked" value="1" />
</form>
</div>

<?php 

