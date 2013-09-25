<?php
/**
* @copyright	Copyright (C) 2009 - 2013 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	Frontend
*/

if(defined('_JEXEC')===false) die();

/**
 * @author bhavya
 * 
 */
class JxiformsHtmlFieldmanipulator
{
	static function edit($options, $value, $fields, $name, $class, $id , $control_name ='')
	{
		self::_getFilterScript($id, $name, $fields, $value, $control_name);
		$html = Rb_Html::_('select.genericlist',  $options, $name , $class, 'value', 'text', $value, $id);
		return $html;
	}
	
	private static function _getFilterScript($id, $name, $fields, $value, $control_name)
	{
		self::_setupManipulatorScript();
		ob_start();
		?>	
		jxiforms.jQuery(document).ready(function(){
			// in case of direct html input(not through XML)'id' is needed to used 
			// on the place of control_name because control_name is blank
			jxiforms.element.fieldmanipulator.insert(
						'<?php  echo Rb_HelperUtils::jsCompatibleId($control_name?$control_name:$id);?>',
						jxiforms.jQuery('#'+ '<?php  echo Rb_HelperUtils::jsCompatibleId($id);?>'),
						<?php echo json_encode($fields);?>
					);
		});
		<?php 
		$content = ob_get_contents();
		ob_end_clean();
		
		JXiFormsFactory::getDocument()->addScriptDeclaration($content);
		return true;
	} 
	
	static function _setupManipulatorScript()
	{
		static $added = false;
		if($added){
			return true;
		}
		
		ob_start();
		?>

		(function($){
			// if elements not defined already
			if(typeof(jxiforms.element)=='undefined'){
				jxiforms.element = {};
			}
	
			jxiforms.element.fieldmanipulator = {
				_queue 	: new Array(),
				_elem_count : 0, 
				_show_queue 	: new Array(),
				
				insert : function(prefix, elem, fields){
					var data = new Object;
					
					data.prefix = prefix;
					data.elem 	= elem[0];
					data.fields = eval(fields);
					
					queue = jxiforms.element.fieldmanipulator._queue;
					queue.push(data);
					if(queue.length == this._elem_count){
						this.init();
					}
				},
				
				init : function(){
					
					queue = jxiforms.element.fieldmanipulator._queue;
					show_queue = jxiforms.element.fieldmanipulator._show_queue ;
					
					// initiliaze all manipulators on screen
					for(var index=0 ; index < queue.length; index++){
						var data = queue[index];
						jxiforms.element.fieldmanipulator.manipulate(data.prefix, data.elem, data.fields);
					}
					
					jxiforms.element.fieldmanipulator._show_queue = new Array();
					
					$('.jxif-fieldmanipulator').change(jxiforms.element.fieldmanipulator.init);
				},
				
				manipulate : function(prefix, elem, fields){
					
					show_queue = jxiforms.element.fieldmanipulator._show_queue ;
					 
					var $elem = $('#'+elem.id);
					// hide all childs
					$.each(fields, function(key, val) {
						$.each(val, function(){
								// only hide if none make it visible
								if(this.toString() != '' && show_queue.indexOf('.' + prefix + this) == -1){
									$('.' + prefix + this).hide();
								}
							});
						});
					
					// show child if, I am visible
					if($elem.is(':visible') == true){
						$.each(fields[$elem.val()], function(){
							//alert("value is "+this);
							if(this.toString() != ''){
								$('.' + prefix + this).show();
								show_queue.push('.' + prefix + this);
							}
						});
					}
				}
			}
			
			$(document).ready(function(){
				jxiforms.element.fieldmanipulator._elem_count = $('.jxif-fieldmanipulator').length;
			});
			
		})(jxiforms.jQuery);


		
		<?php
		$content = ob_get_contents();
		ob_end_clean();
		
		JXiFormsFactory::getDocument()->addScriptDeclaration($content);
		$added = true;
		return true;
	}
}