<?php
/**
* @copyright	Copyright (C) 2009 - 2011 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JXiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/
if(defined('_JEXEC')===false) die();?>

<form action="<?php echo $uri; ?>" method="post" name="adminForm">
	<div class="row-fluid">
		<div class="span12">
			<p class="lead center"><?php echo $heading; ?></p>
			<p class="center"><?php echo $msg; ?></p>
		</div>
		
		<div class="center">
			<a href="http://www.readybytes.net/jxiforms/forum.html" target="_blank" class="btn disabled"><i class="icon-question-sign "></i>&nbsp;<?php echo JText::_('COM_JXIFORMS_SUPPORT_BUTTON');?></a>
			<a href="http://www.readybytes.net/jxiforms/documentation.html" target="_blank" class="btn disabled"><i class="icon-book"></i>&nbsp;<?php echo JText::_('COM_JXIFORMS_DOCUMENTATION_BUTTON');?></a>
		</div>
	</div> 
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<?php 