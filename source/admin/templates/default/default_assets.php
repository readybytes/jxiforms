<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php 

Rb_HelperTemplate::loadSetupEnv();
Rb_HelperTemplate::loadSetupScripts();

Rb_Html::script(UGLYFORMS_PATH_CORE_MEDIA.'/js/uglyforms.js');
Rb_Html::script(dirname(__FILE__).'/_media/js/admin.js');

// load bootsrap css
Rb_Html::_('bootstrap.loadcss');
Rb_Html::stylesheet(dirname(__FILE__).'/_media/css/admin.css');

