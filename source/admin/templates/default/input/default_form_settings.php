<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		jitendra@readybytes.in
* website		http://www.joomlaxi.com
*/

if(defined('_JEXEC')===false) die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select.multiselect');
?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#details" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_EDIT_DETAILS');?></a></li>
		<li><a href="#menuoptions" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_MENU_OPTIONS');?></a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active well" id="details">
			<fieldset class="form-horizontal">								
				<div class="row-fluid">
					<div class="span2"><?php echo $input_fields['title']->label; ?> </div>   
					<div class="span4 offset6">
						<div><?php echo $input_fields['title']->input; ?></div>
						<div class="clr"></div>
						<div class="btn-link" onClick="jxiforms.utils.toggle('input-description');"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_DESCRIPTION_LABEL'); ?></div>
					</div>
				</div>
	
				<div class="control-group hide" id="input-description">
					<div class="controls"><?php echo $input_fields['description']->input; ?></div>				
				</div>
				<div class="row-fluid margin-top2">
					<div class="span2"><?php echo $input_fields['published']->label; ?> </div>
					<div class="span4 offset6"><?php echo $input_fields['published']->input; ?></div>								
				</div>
		
				<div class="row-fluid margin-top2">
					<div class="span2"><?php echo $input_fields['post_url']->label; ?> </div>
					<div class="span9 offset1">
						<div class="jxif-fontsize15">
							<strong><?php echo $help_link;?></strong>
						</div>
						<?php $post_url = $input_fields['post_url']->value;
						if(!empty($post_url)):?>
							<div><?php echo $input_fields['post_url']->value; ?></div>
						<?php else :?>
								<div class="muted"><?php echo Rb_Text::_('COM_JXIFORMS_FORM_POST_URL_MSG_BEFORE_SAVE');?></div>
						<?php endif;?>	
					</div>
				</div>		
				
				<div class="row-fluid margin-top2">
					<div class="span2"><?php echo $input_fields['redirect_url']->label; ?> </div>
					<div class="span4 offset6"><?php echo $input_fields['redirect_url']->input; ?></div>								
				</div>						
				
				<input type="hidden" name="id" value="<?php echo $input_fields['input_id']->value; ?>" />
				<input type="hidden" name="task" value="save" />
				<input type="hidden" name="boxchecked" value="1" />
		</fieldset>
	</div>
				
		<!-- =========================== Menu Options Block======================== -->		
		<div class="tab-pane well" id="menuoptions">
			<div class="row-fluid">
				<div class="form-horizontal">
					<!-- ----------------When input/form is not saved then do no display menu options------------------- -->
					<?php if($input->getId() == 0):?>
					<div class="controls">
						<span class="readonly"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_MENU_CREATE_AFTER_INPUT_SAVE');?></span>
					</div>
					
					<!-- ----------------When input is saved and some menu items are already created for the same ------------------- -->
					<?php elseif (empty($form_menu) ):?>
						<fieldset class="form-horizontal">
							<?php $fieldSets = $inputForm->getFieldsets();?>
							<?php foreach ($fieldSets as $name => $fieldSet) :?>
								<?php if($name == 'menu-attributes'):?>
									<?php foreach ($inputForm->getFieldset($name) as $field):?>
										<div class="control-group">
											<div class="control-label"><?php echo $field->label; ?> </div>
											<div class="controls"><?php echo $field->input; ?></div>								
										</div>
									<?php endforeach;?>
								<?php endif;?>
							<?php endforeach;?>
						
							<div class="controls">
								<?php //JXIF TODO: Move script to admin.js?>
								<script type="text/javascript">
									jxiforms.jQuery(document).ready(function()
									{
										jxiforms.jQuery('#input-createmenu-button').click(function()
										{
											var parent_menu = jxiforms.jQuery('#jxiforms_form_input_menu_location :selected').val();
											var menu_title	= jxiforms.jQuery('#jxiforms_form_input_menu_title').val();
											var menu_alias	= jxiforms.jQuery('#jxiforms_form_input_menu_alias').val();
											var input_id	= "<?php echo $input->getId();?>";
											
											jxiforms.admin.create_menu(parent_menu, menu_title, menu_alias, input_id);							
											
										});
									});
								</script>
								<button type="button" class="btn btn-primary text-right" id="input-createmenu-button">
									<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_MENU_CREATE_BUTTON');?>
						 		</button>
							</div>
													
							
							<!-- --------When input is saved and no menu items exists for it then display parameters to create menu item--------- -->
							<?php else :
								echo $this->loadTemplate("menu_link");
							endif;?>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
<?php 