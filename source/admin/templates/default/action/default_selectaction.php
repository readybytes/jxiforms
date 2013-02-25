<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
*/

if(defined('_JEXEC')===false) die();

//JXITODO : Move javascript code to admin.js
?>
<script type="text/javascript">
jxiforms.jQuery(document).ready(function(){
	var jxi_admin_action_selected = '';

	jxiforms.jQuery('.action-description').hide();
	
	jxiforms.jQuery('.action-type').click(function(){
		var dest_position = jxiforms.jQuery('.action-type:first').position();
		
		jxiforms.jQuery('.action-type').each(function(){
			var src_position = jxiforms.jQuery(this).position();
			jxiforms.jQuery(this).stop().animate({"left" : '-='+(src_position.left-dest_position.left)+'px', 'top' : '-='+(src_position.top-dest_position.top)+'px'}, 250);
			jxiforms.jQuery(this).animate({'opacity': 0},50);
		});

		var src_position = jxiforms.jQuery(this).position();

		jxiforms.jQuery('.action-type').removeClass('action-type').addClass('inactive');
		
		jxiforms.jQuery('.action-description').fadeIn();
		jxi_admin_action_selected = jxiforms.jQuery(this).attr('type');
		jxiforms.jQuery('div.action-description').find('.action-detail').html(jxi_admin_action[jxi_admin_action_selected]['description']);
		jxiforms.jQuery('div.action-description').find('.action-selected-icon').html('<img src="'+jxi_admin_action[jxi_admin_action_selected]['icon']+'">');
		jxiforms.jQuery('div.action-description').find('.action-selected-name').html(jxi_admin_action[jxi_admin_action_selected]['name']);
	});

	jxiforms.jQuery('#restore-actions').click(function(){
		jxiforms.jQuery('.action-description').fadeOut();
			
		jxiforms.jQuery('.inactive').each(function(){				
			jxiforms.jQuery(this).animate({'opacity': 100}, 10).animate({"left" : '0px', 'top' : '0px'}, 350);
			jxiforms.jQuery(this).removeClass('inactive').addClass('action-type');
		});
	});

	jxiforms.jQuery('#action-type-next').click(function(){
		if(jxi_admin_action_selected){
			location.href = 'index.php?option=com_jxiforms&view=action&task=new&type='+jxi_admin_action_selected;
		}
		else {
			return false;
		}
	});
});
</script>

<fieldset >
	<legend>
		<?php echo Rb_Text::_('COM_JXIFORMS_ACTION_SELECT_ACTION');?>
	</legend>
</fieldset>

<!--  =================  All Action List========================== -->
<!--  JXITODO : implement proper fix -->
<div class="position-relative" style="min-height: 250px;">
	<div class="action-list">
		<div class="row-fluid ">
			<div class="span12">
			<?php 
				$details = array();
				foreach ($actions as $type => $action){
					$imagePath  = $action['location'].'/'.$action['icon'];
					$imagePath  = file_exists($imagePath) ? $imagePath : JXIFORMS_PATH_ADMIN_TEMPLATE.'/default/_media/icons/actions.png';
					$details[$type]['description'] = $action['description'];
					$details[$type]['icon'] = Rb_HelperTemplate::mediaURI($imagePath, false);
					$details[$type]['name'] = $action['name'];
					
					?>
					<div class="span2 action-select-list center action-type" type="<?php echo $type;?>">
						<div class="dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $action['name']) ;?></div>
						<div class="dashboard-icon-name"><?php echo $action['name'];?></div>
					</div>
						
				<?php 	} ?> 
			</div>
		</div>					
	</div>
			<script type="text/javascript">var jxi_admin_action = <?php echo json_encode($details);?>;</script>
	
	
	<!--   =============== Action - Detail Block =========================== -->
	
	<div class="row-fluid action-description position-absolute">
		<div class="row-fluid">
			<div class="span12">
				<div class="span2 action-select-list center">
					<div class="action-selected-icon dashboard-icon-image"><?php echo Rb_Html::image(Rb_HelperTemplate::mediaURI($imagePath, false), $action['name']) ;?></div>
			 		<div class="action-selected-name dashboard-icon-name"><?php echo $action['name'];?></div>
				</div>
				<div class="span6 action-detail margin-top2"><?php echo $action['description'];?></div>
				<div class="span3"></div>
			</div>
		</div>
		
		<div class="row-fluid">	
			<div class="span12 margin-top2">
				<div class="span2" id="restore-actions"><a href='#' class="btn"><i class="icon-home"></i><strong><?php echo Rb_Text::_('COM_JXIFORMS_ACTION_SELECT_ACTION_BACK');?></strong></a></div>
				<div class="span6"></div>
				<div class="span3"><a href='#' class="btn btn-primary" id="action-type-next"><strong><?php echo Rb_Text::_('COM_JXIFORMS_ACTION_SELECT_ACTION_NEXT');?></strong> <i class="icon-hand-right icon-white"></i></a></div>
			</div>
		</div>
	</div>
	
</div>
<?php
