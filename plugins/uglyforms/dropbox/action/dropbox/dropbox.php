<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	Frontend
*/
if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 *
 */
class UglyformsActionDropbox extends UglyformsAction
{
	protected $_location	= __FILE__;
	
	public function process($data, $attachments)
	{
		if(empty($attachments)){
			return true;
		}
		
		$email  	  =  $this->getActionParam('email', '');
		$password  	  =  $this->getActionParam('password', '');
		$destination  =  $this->getActionParam('destination', '');
		$uploadField  =  $this->getActionParam('upload_field', '');
		$uploadField  =  empty($uploadField) ? '' : explode(',', $uploadField);
		
		if(!class_exists('DropboxUploader')){
			require_once(__DIR__.'/DropboxUploader.php');
		}
		
		//if nothing is mentioned in upload filed name then upload all the attachment files
		if(empty($uploadField)){
			$uploadField = array_keys($attachments);
		}
		
		$result   = true;
		$uploader = new DropboxUploader($email, $password);
		foreach ($uploadField as $key){
			$key = trim($key);
			if(!isset($attachments[$key])){
				continue ;
			}
			
			$attachment  = JPATH_SITE.$attachments[$key];
			$extension = JFile::getExt($attachment);			
			try{
				$uploader->upload($attachment, $destination, date("d_m_Y_").time().'_'.$key.'.'.$extension);
			}
			catch (Exception $e){
				$result = false ;
				UglyformsHelperUtils::sendEmailToAdmin(Rb_Text::_('COM_UGLYFORMS_ACTION_DROPBOX_ERROR_OCCURRED_IN_FILE_UPLOAD'), Rb_Text::_($e->getMessage()), $attachment);
			}
		}
		
		return $result;
	}

}
