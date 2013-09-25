<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php 

Rb_HelperTemplate::loadSetupEnv();
Rb_HelperTemplate::loadSetupScripts();

Rb_Html::script(JXIFORMS_PATH_CORE_MEDIA.'/js/jxiforms.js');
Rb_Html::script(dirname(__FILE__).'/_media/admin.js');

// load bootsrap css
Rb_Html::_('bootstrap.loadcss');
Rb_Html::stylesheet(dirname(__FILE__).'/_media/admin.css');

