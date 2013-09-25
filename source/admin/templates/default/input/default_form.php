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
<div class="margin-top1">
	<div class="span12">
		<!-- Warning Message-->
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_HTML_CHANGE_ALERT');?>
		</div>
		<div class="alert alert-info">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<?php echo Rb_Text::_('COM_JXIFORMS_INPUT_SUBMIT_BUTTON_HTML_ALERT'); ?>
		</div>
		<!-- Tabs-->
		<ul class="nav nav-tabs margin-top1">
			<li class="active">
				<a href="#form_preview" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_HTML_PREVIEW');?></a>
			</li>
			<li>
				<a href="#form_html" data-toggle="tab"><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_HTML');?></a>
			</li>
		</ul>
		<!-- Tab's Contents-->
		<div class="tab-content well">
			<div class="tab-pane active" id="form_preview">
				<!-- Html of form saved already then show saved HTML-->
				<?php $formHTML = $input_fields['html']->value;
					  if(!empty($formHTML)){
						echo $formHTML.'<div><input type="button" value="Submit" class="btn btn-primary"/> </div><br />';
					  }
					  // Show HTML From Action's XML
					  elseif(isset($code)){
					  		$editableHtml = $code;
					  		$code 		  = str_replace("&lt;", "<", $code);
							$code		  = str_replace("&gt;", ">", $code);							
					  		echo $code.'<div class=""><input type="button" value="Submit" class="btn btn-primary"/> </div>';
					  }?>
				</div>
				<!-- Editable HTML of Form-->
				<div class="tab-pane" id="form_html">
						<?php if(!empty($formHTML)){
								$formHTML = str_replace(">", "&gt;", $formHTML);
								$formHTML = str_replace("<", "&lt;", $formHTML); ?>
							<textarea id="html_code" rows="11" cols="100" name="jxiforms_form[input][html]" class="span11"><?php echo $formHTML;?></textarea>
						<?php }
						else
						{ ?>
							<textarea id="html_code" rows="11" cols="100" name="jxiforms_form[input][html]" class="span11"><?php echo $editableHtml;?></textarea>
					<?php } ?>
				</div>
			</div>
	</div>
</div>
<?php 
