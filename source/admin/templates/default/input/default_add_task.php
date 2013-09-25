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
JHtml::_('behavior.framework');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
?>
<?php //JXIF TODO: Move script to the proper place.?>
<!-- Added because not loading in ajax request.-->
<script type="text/javascript">

/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.isis
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.0
 */
(function($)
{
	$(document).ready(function()
	{
		$('*[rel=tooltip]').tooltip()

		// Turn radios into btn-group
		$('.radio.btn-group label').addClass('btn');
		$(".btn-group label:not(.active)").click(function()
		{
			var label = $(this);
			var input = $('#' + label.attr('for'));

			if (!input.prop('checked')) {
				label.closest('.btn-group').find("label").removeClass('active btn-success btn-danger btn-primary');
				if (input.val() == '') {
					label.addClass('active btn-primary');
				} else if (input.val() == 0) {
					label.addClass('active btn-danger');
				} else {
					label.addClass('active btn-success');
				}
				input.prop('checked', true);
			}
		});
		$(".btn-group input[checked=checked]").each(function()
		{
			if ($(this).val() == '') {
				$("label[for=" + $(this).attr('id') + "]").addClass('active btn-primary');
			} else if ($(this).val() == 0) {
				$("label[for=" + $(this).attr('id') + "]").addClass('active btn-danger');
			} else {
				$("label[for=" + $(this).attr('id') + "]").addClass('active btn-success');
			}
		});
	})
})(jQuery);
</script>
<div class="alert alert-info margin-top1 span12" style="margin-left:0px !important;">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADD_MORE_ACTION_ALERT');?>
</div>
 
<div class="row-fluid margin-top1" id="add_task_form">
	<?php foreach($actions as $actionFields){
		  	$actionType = $actionFields['type']->value;?>
			<div class="well span8" style="margin-left:0px !important;">
				<fieldset class="form-horizontal">
					<legend> <?php echo $xmlData[$actionType]['name'].Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_DETAILS' ); ?> </legend>
					<div class="row-fluid">
						<div class="span3"><?php echo $actionFields['published']->label; ?> </div>
						<div class="span3 offset6">	   <?php echo $actionFields['published']->input; ?> </div>								
					</div>
					
					<div class="row-fluid margin-top2">
						<div class="span3"><?php echo $actionFields['require_approval']->label; ?> </div>
						<div class="span4 offset5">	   <?php echo $actionFields['require_approval']->input; ?> </div>								
					</div>
					
					<fieldset class="form-horizontal">
						<legend> <?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_PARAMETERS' ); ?> </legend>
					
						<?php foreach($actionFields['action_params'] as $actionParam){?>
						<div class="row-fluid margin-top2">
							<div class="span3"><?php echo $actionParam->label; ?> </div>
							<div class="span3 offset6">	   <?php echo $actionParam->input; ?> </div>								
						</div>
						<?php }?>
						<?php if($action[$actionType]->show_editor){ ?>
						<div class="row-fluid margin-top2">
							<div class="span3"><?php echo $actionFields['data']->label; ?> </div>
							<div class="span9">	   <?php echo $actionFields['data']->input; ?> </div>								
						</div>
	  					<?php } ?>
						<?php echo $actionFields['action_id']->input;?>
						<?php echo $actionFields['type']->input;?>
					</fieldset>
				</fieldset>
			</div>
			<div class="span4 well visible-desktop" style="margin-left:1% !important;">
				<fieldset class="form-horizontal">
					<legend>
						<strong><?php echo Rb_Text::sprintf('COM_JXIFORMS_ACTION_HELP', ucfirst($actionType));?></strong>
					</legend>
					<p><?php echo $xmlData[$actionType]['help'];?></p>
				</fieldset>
			</div>
	<?php }?>
</div>

<div class="form-horizontal well <?php if(($actionFields['action_id']->value) == 0 ) echo "hide";?>">
	<script type="text/javascript">
		jxiforms.jQuery(document).ready(function()
		{
			jxiforms.jQuery('#jxif_attach_action').click(function()
			{
				var action_type = jxiforms.jQuery('#action_type :selected').val();
				jxiforms.admin.attach_more_action(action_type);
			});
		});
	</script>
	<div class="control-group">
		<label class="control-label" for="attach_action_type"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_ADD_MORE_ACTION_LABEL');?></label>
		<div class="controls">
			<?php //JXIForms TODO: Move this Php code into view.
				  $actionTypesToIgnore = array();
				  foreach($action as $type => $actionParams)
				  {
						$actionTypesToIgnore[$actionParams->getType()] = $actionParams->getType(); 
				  }
				  echo Rb_Html::_('JxiformsHtml.actiontypes.edit', "action_type", "Add More Action(s)", "Select Action", null, $actionTypesToIgnore);?>
			<button id="jxif_attach_action" class="btn btn-warning input-large margin-left01" type="button">Attach Action</button>
		</div>
	</div>
</div>
<?php 
