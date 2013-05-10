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
		//for menu option form check whether form is valid or not
		if (task == 'createMenu'){
			if(document.formvalidator.isValid(document.id('createMenu'))) {
				Joomla.submitform(task, document.getElementById('createMenu'));
				return true;
			}
			else {
				return false;
			}
		}
		
		if (task == 'cancel' || document.formvalidator.isValid(document.id('adminForm'))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#details" data-toggle="tab"><?php echo JText::_('COM_JXIFORMS_INPUT_EDIT_DETAILS');?></a></li>
		<li><a href="#menuoptions" data-toggle="tab"><?php echo JText::_('COM_JXIFORMS_INPUT_MENU_OPTIONS');?></a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="details">
		
		<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">	
			<div class="row-fluid">	
				<div class="span6">		
					<fieldset class="form-horizontal">								
					
						<div class="control-group">
							<div class="control-label"><?php echo $form->getLabel('title'); ?> </div>
							<div class="controls">
								<div><?php echo $form->getInput('title'); ?></div>
								<div class="clr"></div>
								<div class="btn-link" onClick="jxiforms.utils.toggle('input-description');"><?php echo Rb_Text::_('Add a description'); ?></div>
							</div>
						</div>
						
						<div class="control-group hide" id="input-description">
							<div class="controls"><?php echo $form->getInput('description'); ?></div>				
						</div>
						
						<div class="control-group">
							<div class="control-label"><?php echo $form->getLabel('published'); ?> </div>
							<div class="controls"><?php echo $form->getInput('published'); ?></div>								
						</div>
			
						<div class="control-group">
							<div class="control-label"><?php echo $form->getLabel('post_url'); ?> </div>
						
							<div class="controls">
								<div class="jxif-fontsize15">
									<strong><?php echo $help_link;?></strong>
								</div>
								<?php $post_url = $form->getValue('post_url');
								if(!empty($post_url)):?>
									<div><?php echo $form->getValue('post_url'); ?></div>
								<?php else :?>
									<div class="muted"><?php echo Rb_Text::_('COM_JXIFORMS_FORM_POST_URL_MSG_BEFORE_SAVE');?></div>
								<?php endif;?>	
							</div>
						</div>

						<div class="control-group">
							<div class="control-label"><?php echo $form->getLabel('redirect_url'); ?> </div>
							<div class="controls"><?php echo $form->getInput('redirect_url'); ?></div>								
						</div>
						
						<div class="control-group"> 
							<div class="control-label">
								<label class="hasTip" title="<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_ACTIONS_DESC');?>"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_ACTIONS'); ?></label>
							</div>
							<div class="controls"><?php $actions = $input->getActions();
								 						echo JXiFormsHtml::_('jxiformshtml.actions.edit', 'jxiforms_form[_input_actions]', $actions, array('multiple'=>true, 'style'=>"class='multiselect'"));?></div>				
						</div>
						
						<?php echo $form->getInput('input_id'); ?>
					</fieldset>
				</div>

				<div class="span6">
					<fieldset class="form-horizontal">
					
						<div class="control-group">
							<div class="control-label"><?php echo $form->getLabel('html'); ?> </div>
							<div class="controls"><?php echo $form->getInput('html'); ?></div>
							<div class="clr"></div>
							<?php $html = trim($input->getHtml());?>
							<?php if($input->getId() && !empty($html)) { ?>
								<div class="controls forms-preview-link"><?php echo $preview_link?></div>
							<?php }
								  else{?>
								  	<div class="controls forms-preview-link jxif-opacity45" style="cursor:pointer; color:#0088CC;" title="<?php echo Rb_Text::_('COM_JXIFORMS_FORM_PREVIEW_LINK_TOOLTIP_BEFORE_SAVE');?>"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_HTML_PREVIEW');?></div>
								  <?php }?>			
						</div>
					</fieldset>	
				</div>
			</div>
			
			<input type="hidden" name="task" value="save" />
			<input type="hidden" name="boxchecked" value="1" />		
			</form>
		</div>
<!-- =========================== Menu Options Block======================== -->		
		<div class="tab-pane" id="menuoptions">
			<div class="row-fluid">
			<div class="span6 form-horizontal">
			
			<!-- ----------------When input/form is not saved then do no display menu options------------------- -->
			<?php if($input->getId() == 0):?>
					<div class="controls">
						<span class="readonly"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_MENU_CREATE_AFTER_INPUT_SAVE');?></span>
					</div>
					
			<!-- ----------------When input is saved and some menu items are already created for the same ------------------- -->
				<?php elseif (empty($form_menu) ):?>
					<form action="<?php echo Rb_Route::_('index.php?option=com_jxiforms&view=input&input_id='.$input->getId(), false); ?>" method="post" name="createMenu" id="createMenu">
						<fieldset class="form-horizontal">
							<?php $fieldSets = $form->getFieldsets('advance');?>
							<?php foreach ($fieldSets as $name => $fieldSet) :?>
								<?php if($name == 'menu-attributes'):?>
									<?php foreach ($form->getFieldset($name) as $field):?>
										<div class="control-group">
											<div class="control-label"><?php echo $field->label; ?> </div>
											<div class="controls"><?php echo $field->input; ?></div>								
										</div>
									<?php endforeach;?>
								<?php endif;?>
							<?php endforeach;?>
							<div class="controls">
							 <button type="button" onclick="Joomla.submitbutton('createMenu');" class="btn btn-primary text-right" id="input-createmenu-button" href="#">
								 <?php echo Rb_Text::_('COM_JXIFORMS_INPUT_MENU_CREATE_BUTTON');?>
							 </button>
							</div>
						</fieldset>	
						<input type="hidden" name="task" value="createMenu" />					
					</form>

			<!-- --------When input is saved and no menu items exists for it then display parameters to create menu item--------- -->
				<?php else :?>
					<div class="control-group">
						<div class="control-label"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_AVAILABLE_MENU_ITEMS'); ?> </div>
						<div class="controls"><div class="control-label">
							<?php foreach ($form_menu as $menu):?>
								<div>
									<strong><?php echo JXiFormsHtml::link('index.php?option=com_menus&task=item.edit&id='.$menu->id, $menu->title); ?></strong>
									
									<p class="small"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADVANCE_MENU_ALIAS_LABEL').' : '.$menu->alias; ?><br>
									<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADVANCE_MENU_TYPE').' : '.$menu->menutype; ?></p>
								</div>
							<?php endforeach;?>
						</div></div>
					</div>
				<?php endif;?>
			</div>
			</div>
		</div>

	</div>
<?php 
