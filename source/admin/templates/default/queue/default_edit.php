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

	jxiforms.jQuery(document).ready(function(){
		jxiforms.jQuery('#queue-approve-button').click(function(){
			jxiforms.jQuery("input[name='jxiforms_form\[approved\]']").attr('value', '1');
			jxiforms.jQuery("input[name='task']").attr('value', 'apply');
		});

	});

</script>
<div class="row-fluid">
<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo JText::_('COM_JXIFORMS_QUEUE_EDIT_DETAILS' ); ?> </legend>			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('input_id'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php echo ($input) ? JXiFormsHtml::link('index.php?option=com_jxiforms&view=input&task=edit&input_id='.$input->input_id, $input->title) : $input->input_id.'('.JText::_('COM_JXIFORMS_INPUT_DELETED').')'; ?>
					</div>
				</div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('action_id'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php echo ($action) ? JXiFormsHtml::link('index.php?option=com_jxiforms&view=action&task=edit&action_id='.$action->action_id, $action->title) : $action->action_id.'('.JText::_('COM_JXIFORMS_ACTION_DELETED').')'; ?>
					</div>
				</div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('approved'); ?> </div>
				<div class="controls">
					<div class="control-label">
						<?php $approved = $form->getValue('approved');?>
						<input type="hidden" name="jxiforms_form[approved]" value="<?php echo $approved;?>" />
						<?php if($approved):?>
							<i class="icon-ok"></i>
						<?php else :?>
							<i class="icon-remove"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							 <button type="submit" class="btn" id="queue-approve-button">
							 	<i class="icon-ok"></i>
							 	<strong><?php echo JText::_('COM_JXIFORMS_QUEUE_EDIT_APPROVE_BUTTON');?></strong> 
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
				<div class="controls"><div class="control-label"><?php echo JText::_($status[$form->getValue('status')]); ?></div></div>				
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
				<legend> <?php echo JText::_('COM_JXIFORMS_QUEUE_EDIT_ATTACHMENTS_DETAILS' ); ?> </legend>
				
				<div class="control-group">
					<?php foreach ($queue_attachments as $name =>$file):?>
							<?php if (is_array($file)):?>
								<?php foreach ($file as $attachment):?>
									<div><?php  $extension  = '';
										$properties = explode('.', $attachment);
										if(count($properties) > 1){
											$extension = '.'.array_pop($properties);
										}?>
										<a href="<?php echo JUri::root().$attachment;?>" target="blank"><?php echo $name.$extension;?></a>
									</div>
								<?php endforeach;?>
							<?php else :?>
								<div><?php  $extension  = '';
											$properties = explode('.', $file);
											if(count($properties) > 1){
												$extension = '.'.array_pop($properties);
											}?>
									<a href="<?php echo JUri::root().$file;?>" target="blank"><?php echo $name.$extension;?></a>
								</div>
							<?php endif;?>
					<?php endforeach;?>				
				</div>
			</fieldset>
		<?php endif;?>
		
		<fieldset class="form-horizontal">
			<legend> <?php echo JText::_('COM_JXIFORMS_QUEUE_EDIT_DATA_DETAILS' ); ?> </legend>
		
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
