/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @subpackage	UI
* @contact 		support+jxiforms@readybytes.in
*/

if (typeof(jxiforms)=='undefined'){
	var jxiforms 	= {};
	jxiforms.$ 		= jxiforms.jQuery = rb.jQuery;
	jxiforms.ajax	= rb.ajax;
}


(function($){
// START : 	
// Scoping code for easy and non-conflicting access to $.
// Should be first line, write code below this line.	

/*--------------------------------------------------------------
jxiforms.utils
--------------------------------------------------------------*/
jxiforms.utils = {
		toggle : function(entityId){
	        $("#"+entityId).toggle(300);
		}	
};


/*--------------------------------------------------------------
  on Document ready 
--------------------------------------------------------------*/
$(document).ready(function(){	
});

//ENDING :
//Scoping code for easy and non-conflicting access to $.
//Should be last line, write code above this line.
})(jxiforms.jQuery);