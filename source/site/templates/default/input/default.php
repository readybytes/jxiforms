<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Ugly Forms
* @subpackage	Frontend
* @contact 		support+uglyforms@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<?php if ($input->getId()):?>
	<?php $positions = array('uglyforms-input-display-footer');?>
	<?php $result = $this->loadMultiplePosition($positions);?>

	<div class="row-fluid">
		<?php if($input->isPublished()){?>
		
			 <form action="<?php echo Rb_Route::_('index.php?option=com_uglyforms&view=input&task=submit&input_id='.$input->getId());?>" method="post" name="site<?php echo $this->getName(); ?>Form">
				<?php echo $sample_html; ?>
				
				<!-- ===========TRIGGER POSITION============= -->
				
				<?php foreach ($positions as $position):?>
						<?php if (isset($result[$position]) && is_array($result[$position])):?>
							<?php foreach($result[$position] as $html):?>
								<?php echo $html;?>
							<?php endforeach;?>
						<?php endif;?>
				<?php endforeach;?>

			 </form>
		
		<?php }
		else { ?>
			<div class="alert">
				<h4><?php echo Rb_Text::_('COM_UGLYFORMS_INPUT_FORM_UNPUBLISHED');?></h4>
			</div>
		<?php 
		}?>
		
	</div>
<?php endif;