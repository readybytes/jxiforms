<?php
/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JoomlaXi Forms
* @subpackage	Frontend
* @contact 		joomlaxi@readybytes.in
*/

if(defined('_JEXEC')===false) die(); ?>

<div class="row-fluid">
	<?php if($input->isPublished()){?>
	
		 <form action="<?php echo Rb_Route::_('index.php?option=com_jxiforms&view=input&task=submit&input_id='.$input->getId());?>" method="post" name="site<?php echo $this->getName(); ?>Form">
			<?php echo $sample_html; ?>
		 </form>
	
	<?php }
	else { ?>
		<div class="alert">
			<h4><?php echo Rb_Text::_('COM_JXIFORMS_INPUT_FORM_UNPUBLISHED');?></h4>
		</div>
	<?php 
	}?>
	
</div>
<?php 