<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		Ugly Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.readybytes.net
*/
if(defined('_JEXEC')===false) die();
JHtml::_('behavior.framework');
?>

<!--Congratulation Message-->
<div class="row-fluid show-grid">
	<div class="jxif-setborder jxif-bgcolor-DC ">
		<div class="row-fluid">
			<div class="span6 jxif-padding01">
				<div class="jxif-fontsize15 jxif-textcolor777 jxif-letterspace02"><strong><?php echo Rb_Text::_('COM_UGLYFORMS_INSTALLATION_SUCCESS_MSG');?><br></strong></div>
				<div class="jxif-fontsize12 jxif-textcolor999 jxif-letterspace01 margin-top1"><strong><?php echo Rb_Text::_('COM_UGLYFORMS_INSTALLATION_SUCCESS_MSG_CONTENT');?></strong></div>
			</div>
			<div class="span6 ">
				<div class="jxif-fontsize15 margin-top1 jxif-text-right jxif-padding01">
					<strong><?php echo $howItWorks;?></strong>
				</div>
				<button type="submit" class="btn btn-success btn-large pull-right jxif-textcolor444 jxif-margin-bottom01" onclick="window.location.href='<?php echo JUri::base().'index.php?option=com_uglyforms&view=install&task=complete';?>';">
	  				<i class="icon-hand-right"></i>&nbsp;<?php echo Rb_Text::_('COM_UGLYFORMS_FINISH_INSTALLATION_BUTTON');?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--For Premium And Free Action Blocks-->
<div class="row-fluid">
	<!--For Free Actions Block-->
	<div class="span6 jxif-setborder jxif-bgcolor-DC jxif-margin-bottom03">
		<!--Header-->
		<div class="jxif-heading jxif-fontsize15 jxif-textcolor777 jxif-letterspace02 jxif-padding01 margin-top1"><?php echo Rb_Text::_('COM_UGLYFORMS_PRE_INSTALLED_ACTION_HEADING');?></div>
			<div class="row-fluid">
				<div class="span6 center"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI(UGLYFORMS_PATH_ADMIN_TEMPLATE."/default/_media/icons/free_actions.png", false), Rb_Text::_('COM_UGLYFORMS_PRE_INSTALLED_ACTION_HEADING'));?></div>
					<div class="span6">
						<?php 	$freeAction = array( Rb_Text::_('COM_UGLYFORMS_ACK_BY_EMAIL_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_ACK_BY_SMS_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_DROPBOX_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_EMAIL_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_JOOMLA_LOGIN_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_JOOMLA_REGISTRATION_ACTION'),
													 Rb_Text::_('COM_UGLYFORMS_MAILCHIMP_ACTION')
													 );
								foreach ($freeAction as $key => $action) {?>
								<div class="jxif-textcolor999 jxif-letterspace01 jxif-padding01">
									<span class="jxif-fontsize15 jxif-verticalalign-middle"><?php echo Rb_Text::_('COM_UGLYFORMS_GREATER_THEN_SIGN');?></span>
									<span class="jxif-verticalalign-middle"><?php echo $action;?></span>
								</div>
						<?php }?>
					</div>
			</div>
	</div>
	<!--For Premium Actions Block-->
	<div class="span6 jxif-setborder jxif-bgcolor-DC">
		<div class="jxif-heading jxif-fontsize15 jxif-textcolor777 jxif-letterspace02 jxif-padding01 margin-top1"><?php echo Rb_Text::_('COM_UGLYFORMS_PREMIUM_ACTION_HEADING');?></div>
			<div class="row-fluid">
				<div class="span6 center"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI(UGLYFORMS_PATH_ADMIN_TEMPLATE."/default/_media/icons/premium_actions_bundle.png", false), Rb_Text::_('COM_UGLYFORMS_PREMIUM_ACTION_HEADING'));?></div>
					<div class="span6 ">
						<?php 	$premiumAction = array( Rb_Text::_('COM_UGLYFORMS_ASANA_TASK_ACTION'),
														Rb_Text::_('COM_UGLYFORMS_GITHUB_ISSUE_ACTION'),
														Rb_Text::_('COM_UGLYFORMS_GITHUB_MILESTONE_ACTION'),
														Rb_Text::_('COM_UGLYFORMS_HTTP_QUERY_ACTION'),
														Rb_Text::_('COM_UGLYFORMS_SQL_QUERY_ACTION')
														);
								foreach ($premiumAction as $key => $action) {?>
								<div class="jxif-textcolor999 jxif-letterspace01 jxif-padding01">
									<span class="jxif-fontsize15 jxif-verticalalign-middle"><?php echo Rb_Text::_('COM_UGLYFORMS_GREATER_THEN_SIGN');?></span>
									<span class="jxif-verticalalign-middle"><?php echo $action;?></span>
								</div>
						<?php }?>
						<div class="jxif-margin-bottom03">
							<button type="submit" class="btn btn-warning margin-top2 jxif-textcolor444 jxif-padding02" onclick="window.open('http://www.readybytes.net/download/category/joomlaxi-forms-2.html')">
				  				<i class="icon-shopping-cart"></i>&nbsp;<?php echo Rb_Text::_('COM_UGLYFORMS_GET_PREMIUM_BUNDLE_BUTTON');?>
							</button>
						</div>
					</div>
			</div>
	</div>
	<div class="hide">
		<?php
			$version = new JVersion();
			$suffix = 'jom=J'.$version->RELEASE.'&utm_campaign=broadcast&jxif=JXIF'.UGLYFORMS_VERSION.'&dom='.JURI::getInstance()->toString(array('scheme', 'host', 'port'));?>
			
		<iframe src="http://pub.joomlaxi.com/broadcast/joomlaxi-form/installation.html?<?php echo $suffix?>"></iframe>
	</div>
</div>
<?php 
