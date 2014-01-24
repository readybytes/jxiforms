/**
* @copyright	Copyright (C) 2009 - 2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		Uglyforms
* @subpackage	UI
* @contact 		bhavya@readybytes.in
*/

if (typeof(uglyforms)=='undefined'){
	var uglyforms 	= {};
	uglyforms.$ 		= uglyforms.jQuery = rb.jQuery;
	uglyforms.ajax	= rb.ajax;
}


(function($){
// START : 	
// Scoping code for easy and non-conflicting access to $.
// Should be first line, write code below this line.	

/*--------------------------------------------------------------
uglyforms.utils
--------------------------------------------------------------*/
uglyforms.utils = {
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
})(uglyforms.jQuery);