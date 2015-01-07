<?php 
/**
* @copyright	Copyright (C) 2009 - 2011 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JXiForms
* @subpackage	Frontend
* @contact 		support+jxiforms@readybytes.in
*/
if(defined('_JEXEC')===false) die();?>

<div class="pp-admin-blankgrid">
<form action="<?php echo $uri; ?>" method="post" name="adminForm">
	<?php // echo $this->loadTemplate('filter'); ?>
	<div class="pp-message pp-grid_12">
		<p class="pp-title"> <?php echo $heading; ?></p>
		<p class="pp-description"><?php echo $msg; ?></p>
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
</div>
<?php 