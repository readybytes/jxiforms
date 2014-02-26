<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>
<div class="control-group">
	<div class="control-label"></div>
	<div class="controls"><img src="<?php echo $image_src;?>" alt=""></div>
</div>
<div class="control-group">
	<div class="control-label"><?php echo Rb_Text::_('COM_UGLYFORMS_ACTION_CAPTCHA_ENTER_CAPTCHA');?></div>
	<div class="controls"><input type="text" name="uglyforms_captcha_<?php echo $action_id;?>" value="" /></div>
</div>


