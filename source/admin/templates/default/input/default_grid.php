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

<form action="<?php echo $uri; ?>" method="post" name="adminForm">

	<table class="table table-condensed">
		<thead>
			<!-- TABLE HEADER START -->
			<tr>
				<th  width="1%">
					<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($records); ?>);" />
				</th>
				
				<th class="default-grid-sno">
					<?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_INPUT_GRID_INPUT_ID", 'input_id', $filter_order_Dir, $filter_order);?>
				</th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_INPUT_GRID_TITLE", 'title', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_INPUT_GRID_POSTURL", 'post_url', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_INPUT_GRID_REDIRECTURL", 'redirect_url', $filter_order_Dir, $filter_order);?></th>
				<th><?php echo JXiFormsHtml::_('grid.sort', "COM_JXIFORMS_INPUT_GRID_PUBLISHED", 'published', $filter_order_Dir, $filter_order);?></th>
							
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
					<td><?php echo $record->input_id;?></td>
					<td>
						<div><?php echo JXiFormsHtml::link($uri.'&task=edit&id='.$record->{$record_key}, $record->title);?></div>
						<div><?php echo $record->description;?></div>
					</td>
					<td><?php echo $record->post_url;?></td>
					<td><?php echo $record->redirect_url;?></td>
					<td><?php echo JXiFormsHtml::_("rb_html.boolean.grid", $record, 'published', $count);?></td>
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