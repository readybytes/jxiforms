<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JxiForms
* @subpackage	Backend
* @contact 		support+jxiforms@readybytes.in
* website		http://www.readybytes.net
*/
if(defined('_JEXEC')===false) die();
JHtml::_('behavior.framework');
?>

<!--Congratulation Message-->
<div class="row-fluid">
	
	<div class="row-fluid">
		<div class="alert alert-success center">
			<h3><em><?php echo Rb_Text::_('COM_JXIFORMS_INSTALLATION_SUCCESS_MSG');?></em></h3>
			<p><?php echo Rb_Text::_('COM_JXIFORMS_INSTALLATION_SUCCESS_MSG_CONTENT');?></p>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span6">
			<div class="jxif-install-border">
				<div class="row-fluid">
					<div class="span4 center jxif-vertical-line">
						<span><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI(JXIFORMS_PATH_CORE_MEDIA."/admin/img/free_actions.png", false), Rb_Text::_('JxiForms Actions'));?></span>
						<p><b><?php echo Rb_Text::_('COM_JXIFORMS_INSTALL_ACTIONS');?></b></p>
					</div>	
					<div class="span1"></div>				
					<div class="span7">
						<div class="jxif-unit">
			    			<ul class="message">
			    				<li><?php echo Rb_Text::_('COM_JXIFORMS_EMAIL_ACTION')?></li>
			    				<li><?php echo Rb_Text::_('COM_JXIFORMS_MAILCHIMP_ACTION')?></li>
			    				<li><?php echo Rb_Text::_('COM_JXIFORMS_RESET_PASSWORD_ACTION')?></li>
			    				<li><?php echo Rb_Text::_('COM_JXIFORMS_JOOMLA_REGISTRATION_ACTION')?></li>
			    			</ul>
				    	</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="span6">
			<div class="jxif-install-border">
				<div class="row-fluid">
					<div class="span4 center jxif-vertical-line">
						<span><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI(JXIFORMS_PATH_CORE_MEDIA."/admin/img/app-store.png", false), Rb_Text::_('COM_JXIFORMS_APPSTORE_HEADING'));?></span>
						<p><b><?php echo Rb_Text::_('COM_JXIFORMS_APPSTORE');?></b></p>
					</div>	
					<div class="span1"></div>				
					<div class="span7">
						<div class="jxif-unit">
			    			<span class="jxif-install-header"><?php echo Rb_Text::_('COM_JXIFORMS_APPSTORE_HEADING');?></span>
			    			<p class="message"><?php echo Rb_Text::_('COM_JXIFORMS_APPSTORE_HEADING_MSG')?></p>
						    <p><a href="<?php echo JUri::base().'index.php?option=com_jxiforms&view=appstore';?>" class="btn btn-info"><?php echo Rb_Text::_('COM_JXIFORMS_VISIT_APPSTORE');?></a></p>
				    	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div>&nbsp;</div>
		
	<div class="row-fluid">
		<button type="submit" class="btn btn-success btn-large pull-right" onclick="window.location.href='<?php echo JUri::base().'index.php?option=com_jxiforms&view=install&task=complete';?>';">
	  	<i class="icon-hand-right"></i>&nbsp;<?php echo Rb_Text::_('COM_JXIFORMS_FINISH_INSTALLATION_BUTTON');?>
		</button>
	</div>	
	<div>&nbsp;</div>


	<div class="hide">
		<?php
			$domain  = JURI::getInstance()->toString(array('scheme', 'host', 'port'));
			$version = new JVersion();
			$suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&jxif=JXIF'.JXIFORMS_VERSION.'&dom='.$domain;
			
			$event 		= "product.installation";
			$event_args = array('product'=>'Jxiforms', 'version'=>JXIFORMS_VERSION, 'domain'=>$domain, 'joomla_version'=>$version->RELEASE, 'email'=>$email);
			$event_args = urlencode(json_encode($event_args));?>
			
		<iframe src="http://pub.joomlaxi.com/broadcast/joomlaxi-form/installation.html?<?php echo $suffix?>"></iframe>
		
		<iframe src="http://www.readybytes.net/broadcast/track.html?event=<?php echo $event;?>&event_args=<?php echo $event_args;?>" style="display :none;"></iframe>

	</div>
	</div>
</div>
<?php 
