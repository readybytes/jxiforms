<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class JXiFormsActionDropbox extends JXiformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		if(empty($attachments)){
			return true;
		}
		
		$email  	  =  $this->getActionParam('email', '');
		$password  	  =  $this->getActionParam('password', '');
		$destination  =  JXiFormsHelperRewriter::rewrite($this->getActionParam('destination', ''), $data);
		$uploadField  =  $this->getActionParam('upload_field', '');
		$uploadField  =  empty($uploadField) ? '' : explode(',', $uploadField);
		
		if(!class_exists('DropboxUploader')){
			require_once(__DIR__.'/DropboxUploader.php');
		}
		
		//if nothing is mentioned in upload filed name then upload all the attachment files
		if(empty($uploadField)){
			$uploadField = array_keys($attachments);
		}
		
		$error = array();
		$uploader = new DropboxUploader($email, $password);
		foreach ($uploadField as $key){
			$key = trim($key);
			if(!isset($attachments[$key])){
				continue ;
			}
			
			foreach ($attachments[$key] as $index =>$file){
				$attachment = JPATH_SITE.$file;
				$this->_upload($uploader, $attachment, $destination, $key, $error);
			}
		}
		
		if (!empty($error)){
			return false;
		}
		
		return true;
	}
	
	protected function _upload($uploader, $attachment, $destination, $key, &$error)
	{
		$extension = JFile::getExt($attachment);
		$extension = date("d_m_Y_").time().'_'.$key.'.'.$extension;
		
		try{
			$uploader->upload($attachment, $destination, $extension);
		}
		catch (Exception $e){
			$error[] = true;
			JXiFormsHelperUtils::sendEmailToAdmin(JText::_('COM_JXIFORMS_ACTION_DROPBOX_ERROR_OCCURRED_IN_FILE_UPLOAD'), JText::_($e->getMessage()), $attachment);
		}
	}

}
