<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JxiForms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.joomlaxi.com
*/
if(defined('_JEXEC')===false) die();

JHtml::_('behavior.framework');
?>

<form action="<?php echo $uri; ?>" method="post" name="adminForm" id="adminForm">

	<table class="table table-striped">
		<thead>
			<!-- TABLE HEADER START -->
			<tr>
				<th  width="1%">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
				</th>
				
				<th class="default-grid-sno">
					<?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_ACTION_ID", 'action_id', $filter_order_Dir, $filter_order);?>
				</th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_TITLE", 'title', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_TYPE", 'type', $filter_order_Dir, $filter_order);?></th>
<!-- 				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_FOR_ALL_INPUTS", 'for_all_inputs', $filter_order_Dir, $filter_order);?></th> -->
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_PUBLISHED", 'published', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_ACTION_GRID_ORDERING", 'ordering', $filter_order_Dir, $filter_order);?></th>
							
			</tr>
		<!-- TABLE HEADER END -->
		</thead>
		
		<tbody>
		<!-- TABLE BODY START -->
			<?php $count= $limitstart;			
			foreach ($records as $record):?>
				<tr class="<?php echo "row".$count%2; ?>">								
					<th class="default-grid-chkbox">
				    	<?php echo JXiFormsHtml::_('grid.id', $count, $record->{$record_key} ); ?>
				    </th>
				    <?php if(!empty($enable_plugins) && array_key_exists($record->type, $enable_plugins)){ ?>
				    	<td><?php echo $record->action_id;?></td>
						<td style="width:40%;">
								<div> <?php echo JXiFormsHtml::link($uri.'&task=edit&id='.$record->{$record_key}, $record->title); ?></div>
								<div> <?php echo $record->description;?></div>
						</td>
						<td><?php echo $record->type;?></td>
<!-- 					<td><?php //echo JXiFormsHtml::_("rb_html.boolean.grid", $record, 'for_all_inputs', $count, 'tick.png', 'publish_x.png', '', $langPrefix='COM_JXIFORMS');?></td> -->
						<td><?php echo JXiFormsHtml::_("rb_html.boolean.grid", $record, 'published', $count, 'tick.png', 'publish_x.png', '', $langPrefix='COM_JXIFORMS');?></td>
						<td>
							<span><?php echo $pagination->orderUpIcon( $count , true, 'orderup', Rb_Text::_('COM_JXIFORMS_ORDERING_MOVE_UP')); ?></span>
							<span><?php echo $pagination->orderDownIcon( $count , count($records), true , 'orderdown', Rb_Text::_('COM_JXIFORMS_ORDERING_MOVE_DOWN'), true ); ?></span>
						</td>
					
					<?php }
						  else
						  {?>
							<!--Id-->
							<td><?php echo $record->action_id;?></td>
							<td style="width:40%;"> <?php echo $record->title;?></td>
							<td colspan="3">
						  		<div class="muted"><?php echo Rb_Text::sprintf('COM_JXIFORMS_ACTION_GRID_PLUGIN_NOT_ENABLED',$record->type);?></div>
							</td>
					<?php }?>
				</tr>
			<?php $count++;?>
			<?php endforeach;?>
		<!-- TABLE BODY END -->
		</tbody>
		
		<tfoot>
			<tr>
				<td colspan="7">
					<?php echo $pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
	</table>

	<input type="hidden" name="filter_order" value="<?php echo $filter_order;?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $filter_order_Dir;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
<?php 