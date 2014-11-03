<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php 

Rb_HelperTemplate::loadSetupEnv();
Rb_HelperTemplate::loadMedia();

Rb_Html::script('com_jxiforms/jxiforms.js');
Rb_Html::script('com_jxiforms/admin/admin.js');
Rb_Html::stylesheet('com_jxiforms/admin/admin.css');

