/**
* @copyright	Copyright (C) 2009-2012 Ready Bytes Software Labs Pvt. Ltd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* @package		JXiForms
* @contact 		bhavya@readybytes.in
*/

//define jxiforms, if not defined.
if (typeof(jxiforms)=='undefined'){
	var jxiforms = {}
}

// all admin function should be in admin scope 
if(typeof(jxiforms.admin)=='undefined'){
	jxiforms.admin = {};
}

//all admin function should be in admin scope 
if(typeof(Joomla)=='undefined'){
	Joomla = {};
}


(function($){
// START : 	
// Scoping code for easy and non-conflicting access to $.
// Should be first line, write code below this line.	
	
jxiforms.admin = {
		attach_more_action : function(actionType){
			var args = { 'event_args' : {'action_type' : actionType} };
			var url  = 'index.php?option=com_jxiforms&view=input&task=addAction';
			jxiforms.ajax.go(url, args);
		},
		
		create_menu : function(parent_menu, menu_title, menu_alias, input_id)
		{
			var args = { 'event_args' : {'parent_menu' : parent_menu,
						 				 'menu_title'  : menu_title,
						 				 'menu_alias'  : menu_alias,
						 				 'input_id'    : input_id}
						};
		
			var url  = 'index.php?option=com_jxiforms&view=input&task=createMenu';
			jxiforms.ajax.go(url, args);
		}
}	
/*--------------------------------------------------------------
jxiforms.admin.grid
	submit
	filters
--------------------------------------------------------------*/
jxiforms.admin.grid = {
		
		//default submit function
		submit : function( view, action, validActions){
			
			// try views function if exist
			var funcName = view+'_'+ action ; 
			if(this[funcName] instanceof Function) {
				if(this[funcName].apply(this) == false)
					return false;
			}
			
			// then lastly submit form
			//submitform( action );
			if (action) {
		        document.adminForm.task.value=action;
		    }
			
			// validate actions
			//XITODO : send values as key of array , saving a loop
			validActions = eval(validActions);
			var isValidAction = false;
			for(var i=0; i < validActions.length ; i++){
				if(validActions[i] == action){
					isValidAction = true;
					break;
				}
			}
			
						
			var result = true;
		    if (document.adminForm.onsubmit instanceof Function) {
			    result = document.adminForm.onsubmit.apply(this, Array(isValidAction));
				// below code is not working on IE7+, so added above line
		        //result=document.adminForm.onsubmit(isValidAction);
		    }
		    if(result){
		    	document.adminForm.submit();
		    }
		},
		
		filters : {
			reset : function(form){
				 // loop through form elements
			    var str = new Array();
                            var i=0;
			    for(i=0; i<form.elements.length; i++)
			    {
			        var string = form.elements[i].name;
			        if (string && string.substring(0,6) == 'filter' && (string!='filter_reset' && string!='filter_submit'))
			        {
			            form.elements[i].value = '';
			        }
			    }
				this.submit(view,null,validActions);
			}
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