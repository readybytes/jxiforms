<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
* @package		JoomlaXi Forms
* @subpackage	Backend
* @contact 		bhavya@readybytes.in
* website		http://www.joomlaxi.com
*/
if(defined('_JEXEC')===false) die();

JHtml::_('behavior.framework');
?>

<form action="<?php echo $uri; ?>" method="post" id="adminForm" name="adminForm">

	<table class="table table-condensed">
		<thead>
			<!-- TABLE HEADER START -->
			<tr>
				<th  width="1%">
					<input type="checkbox" name="toggle" value="" onclick="Joomla.checkAll(this);" />
				</th>
				
				<th class="default-grid-sno">
					<?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_QUEUE_ID", 'queue_id', $filter_order_Dir, $filter_order);?>
				</th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_INPUT_ID", 'input_id', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_ACTION_ID", 'action_id', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_STATUS", 'status', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_APPROVED", 'approved', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo Rb_Text::_('COM_JXIFORMS_QUEUE_GRID_APPROVAL_KEY');?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_QUEUE_GRID_CREATED_DATE", 'created_date', $filter_order_Dir, $filter_order);?></th>
							
			</tr>
			<!-- TABLE HEADER END -->
		</thead>
		
		<tbody>
		<!-- TABLE BODY START -->
			<?php $count= $limitstart;
			$cbCount = 0;
			foreach ($records as $record):?>
				<tr class="<?php echo "row".$count%2; ?>">								
					<th class="default-grid-chkbox">
				    	<?php echo JXiFormsHtml::_('grid.id', $cbCount++, $record->{$record_key} ); ?>
				    </th>				
					<td><?php echo $record->queue_id;?></td>
					<td><?php echo $record->input_id;?></td>
					<td><?php echo $record->action_id;?></td>
					<td><?php echo $record->status;?></td>
					<td><?php echo $record->approved;?></td>
					<td><?php echo $record->approval_key;?></td>
					<td><?php echo $record->created_date;?></td>
				</tr>
			<?php $count++;?>
			<?php endforeach;?>
		<!-- TABLE BODY END -->
		</tbody>
		
		<tfoot>
			<tr>
				<td colspan="8">
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