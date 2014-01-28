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
		var uglyforms_form_jsoncontent = '<?php echo $input->getParam('jsoncontent');?>';
</script>

<link href="<?php echo Rb_HelperTemplate::mediaURI(dirname(dirname(__FILE__)).'/_media/css/custom.css', false);?>" rel="stylesheet">
<!--[if lt IE 9]>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<link rel="shortcut icon" href="images/favicon.ico">
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

<div class="tabbable tabs-left">

  <ul class="nav nav-tabs" id="uglyforms-form-tab">

   	<li class="active"><a href="#details" data-toggle="tab">Form Details</a></li>
   	<li><a href="#menuoptions" data-toggle="tab">Menu Options</a></li>
   	
  </ul>
  

  
  	<div class="tab-content">
          
          <div class="tab-pane active" id="details">
				<!-- ======================== FORM DETAILS START===================================== -->
				<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm" class="rb-validate-form">
					<div class="row-fluid">
					
						<div class="span9">		
							<fieldset class="form-horizontal">								
							
								<div class="control-group">
									<div class="control-label"><?php echo $form->getLabel('title'); ?> </div>
									<div class="controls">
										<div><?php echo $form->getInput('title'); ?></div>
										<div class="clr"></div>
										<div class="btn-link" onClick="uglyforms.utils.toggle('input-description');"><?php echo Rb_Text::_('Add a description'); ?></div>
									</div>
								</div>
								
								<div class="control-group hide" id="input-description">
									<div class="controls"><?php echo $form->getInput('description'); ?></div>				
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
											<div class="muted"><?php echo Rb_Text::_('COM_UGLYFORMS_FORM_POST_URL_MSG_BEFORE_SAVE');?></div>
										<?php endif;?>	
									</div>
								</div>		
								
								<?php echo $form->getInput('input_id'); ?>
							</fieldset>
						</div>
		
						<div class="span3">
							<fieldset>
								
								<div class="control-group">
									<div class="control-label"><?php echo $form->getLabel('published'); ?> </div>
									<div class="controls"><?php echo $form->getInput('published'); ?></div>								
								</div>
								
								<div class="control-group">
									<div class="control-label"><?php echo $form->getLabel('redirect_url'); ?> </div>
									<div class="controls"><?php echo $form->getInput('redirect_url'); ?></div>								
								</div>
								
								<div class="control-group"> 
									<div class="control-label">
										<label class="hasTip" title="<?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_EDIT_ACTIONS_DESC');?>"><?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_EDIT_ACTIONS'); ?></label>
									</div>
									<div class="controls"><?php $actions = $input->getActions();
										 						echo UglyformsHtml::_('uglyformshtml.actions.edit', 'uglyforms_form[_input_actions]', $actions, array('multiple'=>true, 'style'=>"class='multiselect'"));?></div>				
								</div>
							
							</fieldset>	
						</div>
					</div>
					<textarea name="uglyforms_form[params][jsoncontent]" id="uglyforms_form_params_jsoncontent" class="hide"><?php echo $input->getParam('jsoncontent');?></textarea>
					
					<div class="hide"><?php echo $form->getInput('html'); ?></div>
					<input type="hidden" name="task" value="save" />
					<input type="hidden" name="boxchecked" value="1" />		
				</form>
					<!-- ======================== FORM DETAILS END===================================== -->
					
					 <div class="tab-pane active" id="builder">
          			<!-- ======================== FORM BUILDER START===================================== -->
          		
          		
		          		<div class="row-fluid clearfix">
		          		
		          		<!--  Components -->
		          		
		          		 <div id="drag-drop-components" class="span6">
					        
					            <h4>Drag And Drop components</h4>
					            <hr>
					            <div class="tabbable">
					              <ul class="nav nav-tabs" id="form-builder-navtab">
					                <!-- Tab nav -->
					              </ul>
					              <div id="components-parent">
					                <form class="form-horizontal" id="components">
					                  <fieldset>
					                    <div class="tab-content" id="form-builder-tabcontent">
					                      <!-- Tabs of snippets go here -->
					                    </div>
					                  </fieldset>
					                </form>
					              </div>
					            </div>
					         
		       			</div>
		        		<!-- / Components -->
		
		
			       		<!-- Building Form. -->
				        <div class="span6">
				          <div class="clearfix">
				            <h4>Your Form</h4>
				            <hr>
				            <div id="build">
				              <form id="target" class="form-horizontal">
				              </form>
				            </div>
				          </div>
				        </div>
				        <!-- / Building Form. -->
		          		
		          		
		          </div>

    			<script data-main="<?php echo Rb_HelperTemplate::mediaURI(dirname(dirname(__FILE__)).'/_media/js/main-built.js', false);?>" src="<?php echo Rb_HelperTemplate::mediaURI(dirname(dirname(__FILE__)).'/_media/js/require.js', false);?>" ></script>
 			<!-- ======================== FORM BUILDER END===================================== -->
      	    </div>
		</div>
          
          
          <div class="tab-pane" id="menuoptions">
          	<!-- ======================== FORM MENU-CREATION START===================================== -->
			<div class="row-fluid">
			<div class="span6 form-horizontal">
			
			<!-- ----------------When input/form is not saved then do no display menu options------------------- -->
			<?php if($input->getId() == 0):?>
					<div class="controls">
						<span class="readonly"><?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_MENU_CREATE_AFTER_INPUT_SAVE');?></span>
					</div>
					
			<!-- ----------------When input is saved and some menu items are already created for the same ------------------- -->
				<?php elseif (empty($form_menu) ):?>
					<form action="<?php echo Rb_Route::_('index.php?option=com_uglyforms&view=input&input_id='.$input->getId(), false); ?>" method="post" name="createMenu" id="createMenu" class="rb-validate-form" >
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
							<input type="submit" class="btn btn-primary text-right" id="input-createmenu-button" value="<?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_MENU_CREATE_BUTTON');?>" />
							</div>
						</fieldset>	
						<input type="hidden" name="task" value="createMenu" />					
					</form>

			<!-- --------When input is saved and no menu items exists for it then display parameters to create menu item--------- -->
				<?php else :?>
					<div class="control-group">
						<div class="control-label"><?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_AVAILABLE_MENU_ITEMS'); ?> </div>
						<div class="controls"><div class="control-label">
							<?php foreach ($form_menu as $menu):?>
								<div>
									<strong><?php echo UglyformsHtml::link('index.php?option=com_menus&task=item.edit&id='.$menu->id, $menu->title); ?></strong>
									
									<p class="small"><?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_ADVANCE_MENU_ALIAS_LABEL').' : '.$menu->alias; ?><br>
									<?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_ADVANCE_MENU_TYPE').' : '.$menu->menutype; ?></p>
								</div>
							<?php endforeach;?>
						</div></div>
					</div>
				<?php endif;?>
			</div>
			</div>
			<!-- ======================== FORM MENU-CREATION END===================================== -->
			
		</div>
 	</div>
 	
</div>
   

<?php 
