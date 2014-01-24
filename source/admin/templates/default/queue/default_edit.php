<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.readybytes.net
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

	uglyforms.jQuery(document).ready(function(){
		uglyforms.jQuery('#queue-approve-button').click(function(){
			uglyforms.jQuery("input[name='uglyforms_form\[approved\]']").attr('value', '1');
			uglyforms.jQuery("input[name='task']").attr('value', 'apply');
		});

	});

</script>
<div class="row-fluid">
<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo Rb_Text::_('COM_UGLYFORMS_QUEUE_EDIT_DETAILS' ); ?> </legend>			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('input_id'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php echo ($input) ? UglyformsHtml::link('index.php?option=com_uglyforms&view=input&task=edit&input_id='.$input->input_id, $input->title) : $input->input_id.'('.Rb_Text::_('COM_UGLYFORMS_INPUT_DELETED').')'; ?>
					</div>
				</div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('action_id'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php echo ($action) ? UglyformsHtml::link('index.php?option=com_uglyforms&view=action&task=edit&action_id='.$action->action_id, $action->title) : $action->action_id.'('.Rb_Text::_('COM_UGLYFORMS_ACTION_DELETED').')'; ?>
					</div>
				</div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approved'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php $approved = $form->getValue('approved');?>
						<input type="hidden" name="uglyforms_form[approved]" value="<?php echo $approved;?>" />
						<?php if($approved):?>
							<i class="icon-ok"></i>
						<?php else :?>
							<i class="icon-remove"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							 <button type="submit" class="btn" id="queue-approve-button">
							 	<i class="icon-ok"></i>
							 	<strong><?php echo Rb_Text::_('COM_UGLYFORMS_QUEUE_EDIT_APPROVE_BUTTON');?></strong> 
							</button> 
						<?php endif;?>
					</div>
				</div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approval_key'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php $approval_key = $form->getValue('approval_key');
							  echo empty($approval_key) ? '-' : $approval_key; ?>
					</div>
				</div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('status'); ?> </div>
				<div class="controls"><div class="control-label"><?php echo Rb_Text::_($status[$form->getValue('status')]); ?></div></div>				
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('created_date'); ?> </div>
				<div class="controls"><div class="control-label"><?php echo $form->getValue('created_date'); ?></div></div>				
			</div>
			<?php echo $form->getInput('queue_id'); ?>
		</fieldset>
	</div>
	
	<div class="span6">
	
		<?php if(count($queue_attachments) > 0):?>
			<fieldset class="form-horizontal">
				<legend> <?php echo Rb_Text::_('COM_UGLYFORMS_QUEUE_EDIT_ATTACHMENTS_DETAILS' ); ?> </legend>
				
				<div class="control-group">
					<?php foreach ($queue_attachments as $name =>$file):?>
							<div><?php  $extension  = '';
										$properties = explode('.', $file);
										if(count($properties) > 1){
											$extension = '.'.array_pop($properties);
										}?>
								<a href="<?php echo JUri::root().$file;?>" target="blank"><?php echo $name.$extension;?></a>
							</div>
					<?php endforeach;?>				
				</div>
			</fieldset>
		<?php endif;?>
		
		<fieldset class="form-horizontal">
			<legend> <?php echo Rb_Text::_('COM_UGLYFORMS_QUEUE_EDIT_DATA_DETAILS' ); ?> </legend>
		
						<?php foreach ($queue_data as $key=>$value):?>
								<div class="control-group">
								<div class="control-label"><?php echo $key?> </div>
								<div class="controls"><div class="control-label"><?php echo $value;?> </div></div>
								</div> 
						<?php endforeach;?>
			
		</fieldset>	
	</div>

<input type="hidden" name="task" value="save" />
	<input type="hidden" name="boxchecked" value="1" />
</form>
</div>
<?php 
