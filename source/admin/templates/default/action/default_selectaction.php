<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();?>

<div>

	<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">
	<div>	
		<span><?php echo JXiFormsHtml::_('jxiformshtml.actiontypes.edit', 'type', '', array('none'=>true)); ?></span>
		<span><input type="submit" name="submit" value="Submit"/></span>
	</div>
	<input type="hidden" name="task" value="new" />

</form>
</div>
<?php 
