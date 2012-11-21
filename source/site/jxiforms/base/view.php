<?php
/**
* @copyright 	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Joomlaxi Forms	
* @subpackage	Frontend
* @contact 		bhavya@readybytes.in
*/
if(defined('_JEXEC')===false) die();


if(RB_REQUEST_DOCUMENT_FORMAT === 'ajax'){
	class JXiFormsViewbase extends Rb_ViewAjax{}
}elseif(RB_REQUEST_DOCUMENT_FORMAT === 'json'){
	class JXiFormsViewbase extends Rb_ViewJson{}
}else{
	class JXiFormsViewbase extends Rb_ViewHtml{}
}

class JXiFormsView extends JXiFormsViewbase 
{
	public $_component = JXIFORMS_COMPONENT_NAME;
	
	public function __construct($config = array())
	{
		parent::__construct($config);
		
		self::addSubmenus(array('dashboard', 'input', 'action'));
		return $this;
	}
	

}
