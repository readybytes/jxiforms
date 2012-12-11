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

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_DETAILS' ); ?> </legend>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('title'); ?> </div>
				<div class="controls"><?php echo $form->getInput('title'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('type'); ?> </div>
				<div class="controls"><?php echo $form->getInput('type'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('published'); ?> </div>
				<div class="controls"><?php echo $form->getInput('published'); ?></div>								
			</div>

			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('for_all_inputs'); ?> </div>
				<div class="controls"><?php echo $form->getInput('for_all_inputs'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('description'); ?> </div>
				<div class="controls"><?php echo $form->getInput('description'); ?></div>				
			</div>

		 	<div class="control-group">
				<div class="control-label">
					<label class="hasTip" title="<?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_INPUTS_DESC');?>"><?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_INPUTS'); ?></label>
				</div>
				<div class="controls"><?php $inputs = $action->getInputs();
					 						echo JXiFormsHtml::_('jxiformshtml.inputs.edit', 'jxiforms_form[_action_inputs]', $inputs, array('multiple'=>true, 'style'=>"class='multiselect'"));?></div>				
			</div>
					
			<?php echo $form->getInput('action_id'); ?>
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
		
		
		
	</fieldset>	
	</div>
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="boxchecked" value="1" />
</form>


