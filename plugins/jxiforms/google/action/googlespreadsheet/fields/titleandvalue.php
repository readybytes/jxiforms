<?php
/**
* @copyright	Copyright (C) 2009 - 2009 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

jimport('joomla.form.formfield');
/**
 * @author bhavya
 */
class JXiFormsFormFieldTitleandvalue extends JFormField
{	
	protected $type = 'titleandvalue';
	
	function getInput()
	{
		$class = ( (string)$this->element['class'] ? (string)$this->element['class'] : 'inputbox' );
		$options = array ();
		$fields  = array();
		
		$values = !empty($this->value) ? $this->value : false;
		$html = '<div id="jxif_titleandvalue">';
		
		$count = ( isset($values['title']) && count($values['title']) > 0 ) ? count($values['title']) : 1; 
		for($i=0; $i < $count ; $i++)
		{
			$titleHtml = '<input type="text" name="'.$this->name.'[title][]" id="'.$this->name.'_title_'.$i.'" value="'.$values['title'][$i].'" />&nbsp;';
			$valueHtml = '<input type="text" name="'.$this->name.'[value][]" id="'.$this->name.'_value_'.$i.'" value="'.$values['value'][$i].'" />';
			
			$html .= '<div class="row_'.$i.'">'.$titleHtml.$valueHtml;
			$html .= '<a href="#" class="jxif_titleandvalue_remove" counter="'.$i.'"><i class="icon-remove"></i></a><div class="clr"></div>';			
			$html .= '<br></div>'; 
		}
		
		self::_getFilterScript($this->name, $i);
		
		return $html.'</div><a id="jxif_titleandvalue_add" href="#"><i class="icon-plus"></i></a>';
	}
	
	protected static function _getFilterScript($name, $count)
	{
		ob_start();
		?>	
		(function($){
			$(document).ready(function(){
				var DefaultNumber = <?php echo $count;?>;
			
				// if elements not defined already
				if(typeof(jxiforms.element)=='undefined'){
					jxiforms.element = {};
				}
							
				$('#jxif_titleandvalue_add').click(function(){
					$( "#jxif_titleandvalue" ).append(jxiforms.element.titleandvalue.getElementHtml(DefaultNumber));
					DefaultNumber++;
					return false;
				});
				
				$('.jxif_titleandvalue_remove').live('click', function(){
					$('.row_'+ $(this).attr('counter')).remove();
					return false;
				});
				
				
				// if elements not defined already
				if(typeof(jxiforms.element.titleandvalue)=='undefined'){
					jxiforms.element.titleandvalue = {};
				}
		
				jxiforms.element.titleandvalue = {
					getElementHtml : function(counter){
						var html = '';
						html += '<div class="row_'+ counter +'">';
						html += '<input type="text" value="" id="jxiforms_form[action_params]column_title_'+counter+'" name="jxiforms_form[action_params][column][title][]" class="">&nbsp;';
						html += '<input type="text" value="" id="jxiforms_form[action_params]column_value_'+counter+'" name="jxiforms_form[action_params][column][value][]" class="">';
						html +=	'<a counter="'+counter+'" class="jxif_titleandvalue_remove" href="#">';
						html += '<i class="icon-remove"></i>';
						html += '</a>';
						html += '<div class="clr"></div>';
						html += '</div>';
						html += '<br>';
								
						return html;
						}
					}
			});				
		})(jxiforms.jQuery);
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		
		JXiFormsFactory::getDocument()->addScriptDeclaration($content);
	}
}