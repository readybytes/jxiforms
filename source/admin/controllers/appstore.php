<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Backend
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @author bhavya
 *
 */

class JXiFormsAdminControllerAppstore extends JXiFormsController
{
	function getModel($name = '', $prefix = '', $config = array())
	{
		return null;
	}
	
	public function display($cachable = false, $urlparams = array())
	{
		$db		= JXiFormsFactory::getDbo();
		$query	= 'SELECT * FROM `#__extensions`'
				 .'WHERE `type` LIKE "component"'
				 .'AND `element` LIKE "com_rbinstaller"';
				
		$db->setQuery($query);
		$object = $db->loadObject();
		if(!$object)
		{
	 		$file_url  = 'http://pub.readybytes.net/rbinstaller/update/live.json';
     		$link     = new JURI($file_url);  
      		$curl     = new JHttpTransportCurl(new Rb_Registry());
     		$response   = $curl->request('GET', $link);
      
      		if($response->code != 200){
      			$msg = Rb_Text::_('COM_JXIFORMS_UNABLE_TO_FIND_FILE');
       	 		$this->setRedirect("index.php?option=com_jxiforms", $msg, 'error');
       	 		return false;
      		}
                
     		$content   	=  json_decode($response->body, true);    
     		$file_path	= new JUri($content['rbinstaller']['file_path']);
			
			$data			= $curl->request('GET', $file_path);		
			$content_type 	= $data->headers['Content-Type'];
    
   			 if ($content_type != 'application/zip'){ 
   			 	$msg = Rb_Text::_('COM_JXIFORMS_UNABLE_TO_FIND_FILE');
      			$this->setRedirect("index.php?option=com_jxiforms", $msg, 'error');
      			return false;
   		 	}
    		else {
      			$file =  $data->body;
				if(!JXiFormsHelperUtils::install($file)){
					$msg  = Rb_Text::_('COM_JXIFORMS_INSTALLATIN_FAILED');
					$this->setRedirect("index.php?option=com_jxiforms", $msg, 'error');
					return false;
				}
			}
		}
		
		//In case rbinstaller is installed but disable
		elseif (!$object->enabled){
			$this->setRedirect("index.php?option=com_installer&view=manage&filter_search=rb", Rb_Text::_('COM_JXIFORMS_ENABLE_RBINSTALLER'), 'warning');
			return false;
		}
       	 		
		$this->setRedirect("index.php?option=com_rbinstaller&view=item&product_tag=rbappsjxiforms&tmpl=component#/app");
		return false;
	}
}
