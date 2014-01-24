<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php 

Rb_HelperTemplate::loadSetupEnv();
Rb_HelperTemplate::loadSetupScripts();

Rb_Html::script(UGLYFORMS_PATH_CORE_MEDIA.'/uglyforms.js');

// load bootsrap css
Rb_Html::_('bootstrap.loadcss');
//Rb_Html::stylesheet(dirname(__FILE__).'/_media/admin.css');

//Rb_Html::stylesheet(UGLYFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/assets/css/custom.css');

