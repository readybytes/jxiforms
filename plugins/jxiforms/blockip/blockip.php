<?php

/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @contact		support@readybytes.in
* @author		Bhavya Shaktawat
*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

if(!defined('RB_FRAMEWORK_LOADED')){
	return true;
}

$fileName 	= JPATH_SITE. '/components/com_jxiforms/jxiforms/includes.php';
if(!JFile::exists($fileName)){
	return true;
}
else {
	require_once $fileName;
}
class  plgSystemBlockip extends Rb_Plugin
{
		function onJXIFormsDataPrepare(&$data)
		{
			$data['user_ip']	=	isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] 
								: ( isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : Rb_Text::_('COM_JXIFORMS_LOGGER_REMOTE_IP_NOT_DEFINED')) ;
			return true;
		}
		
		function onAfterRoute()
		{
			$app 	= Rb_Factory::getApplication();
			$input 	= $app->input;

			$option = $input->get('option', false);
			$task =   $input->get('task', false);
			$action =   $input->get('action', false);
			
			$user_ip 				= 	$input->get('ip_to_block', '');
			$plg_secret_keyword 	= 	$this->params->get('secret_keyword', false);
			$plg_keyword_value 		= 	$this->params->get('keyword_value', false);

			//keyword expected in request and its value must be same as set in the plugin
			$secret_keyword 		=   $input->get($plg_secret_keyword, false);
			
			if ($option == 'com_jxiforms' && $task == 'blockip' && $action == 'confirmed' ){
											
				//if none of the required parameter is empty 
				//and secret keyword and response matched with the one in request
				//then generate error log
				if (!empty($user_ip) && !empty($secret_keyword) && $secret_keyword == $plg_keyword_value){
								
					$plg_error_log 	= $this->params->get('error_log', false);
								
					error_log($plg_error_log.$user_ip, 0);
					$app->redirect('index.php', $plg_error_log);
				}
				else{
					$app->redirect('index.php', "Invalid Data Supplied to Block the IP", 'warning');
				}
			}
			
			//confirmation for blocking the provided User IP
			if ($option == 'com_jxiforms' && $task == 'blockip' && $action == 'confirm' ){
				$action_url = Rb_Route::_('index.php?option=com_jxiforms&task=blockip&action=confirmed');
				echo '<form action="'.$action_url.'" method="POST">
						User IP : <input type="text" name="ip_to_block" value="'.$user_ip.'" readonly="true" />
						Enter Secret Answer : <input type="text" name="'.$plg_secret_keyword.'" value="Enter secret value" />
						<input type="submit" name="confirm_ipblock" value="Block" />
					</form>';
				exit();
			}
			
			return true;
		}
}

