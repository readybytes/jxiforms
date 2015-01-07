<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php if($input->isPublished()){
	echo $sample_html;
}
else { ?>
	<div class="alert">
		<h4><?php echo JText::_('COM_JXIFORMS_INPUT_FORM_UNPUBLISHED');?></h4>
	</div>
<?php 
}