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
			<legend> <?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_DETAILS' ); ?> </legend>								
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('title'); ?> </div>
				<div class="controls"><?php echo $form->getInput('title'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('published'); ?> </div>
				<div class="controls"><?php echo $form->getInput('published'); ?></div>								
			</div>

			<?php $post_url = $form->getValue('post_url');
			if(!empty($post_url)):?>
				<div class="control-group">
					<div class="control-label"><?php echo $form->getLabel('post_url'); ?> </div>
					<div class="controls"><?php echo $form->getInput('post_url'); ?></div>								
				</div>
			<?php endif;?>			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('redirect_url'); ?> </div>
				<div class="controls"><?php echo $form->getInput('redirect_url'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('description'); ?> </div>
				<div class="controls"><?php echo $form->getInput('description'); ?></div>				
			</div>
			<?php echo $form->getInput('input_id'); ?>
		</fieldset>
	</div>

	<div class="span6">
	<fieldset class="form-horizontal">
	<legend> <?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ACTIONS' ); ?> </legend>

			<div class="control-group"> 
				<div class="control-label">
					<label class="hasTip" title="<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_ACTIONS_DESC');?>"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_ACTIONS'); ?></label>
				</div>
				<div class="controls"><?php $actions = $input->getActions();
					 						echo JXiFormsHtml::_('jxiformshtml.actions.edit', 'jxiforms_form[_input_actions]', $actions, array('multiple'=>true, 'style'=>"class='multiselect'"));?></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('html'); ?> </div>
				<div class="controls"><?php echo $form->getInput('html'); ?></div>
				<?php $html = trim($input->getHtml());?>
				<?php if($input->getId() && !empty($html)): ?>
					<div class="controls forms-preview-link"><?php echo $preview_link?></div>
				<?php endif;?>			
			</div>
	</fieldset>	
	</div>
	
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="boxchecked" value="1" />
</form>
</div>
<?php 