<?php
/**
* @copyright	Copyright (C) 2009 - 2014 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>
 <script type="text/javascript">
 var RecaptchaOptions = {
    theme : '<?php echo $recaptcha_theme;?>'
 };
 </script>
<div class="control-group">
	<div class="control-label"></div>
	<div class="controls"><?php echo $recaptcha_html;?></div>
</div>