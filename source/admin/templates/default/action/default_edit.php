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
?>

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div class="span6">		
		<fieldset class="form-horizontal">
			<legend> <?php echo Rb_Text::_('COM_JXIFORMS_ACTION_EDIT_DETAILS' ); ?> </legend>
					
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('action_id'); ?> </div>
				<div class="controls"><?php echo $form->getInput('action_id'); ?></div>								
			</div>
			
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
				<div class="control-label"><?php echo $form->getLabel('is_core'); ?> </div>
				<div class="controls"><?php echo $form->getInput('is_core'); ?></div>								
			</div>
			
			<div class="control-group">
				<div class="control-label"><?php echo $form->getLabel('description'); ?> </div>
				<div class="controls"><?php echo $form->getInput('description'); ?></div>				
			</div>
		</fieldset>
	</div>
	
	<input type="hidden" name="task" value="save" />
	<input type="hidden" name="boxchecked" value="1" />
</form>


