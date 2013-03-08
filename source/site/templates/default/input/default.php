<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		joomlaxi@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php if($input->isPublished()){
	echo $sample_html;
}
else { ?>
	<div class="alert">
		<h4><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_FORM_UNPUBLISHED');?></h4>
	</div>
<?php 
}