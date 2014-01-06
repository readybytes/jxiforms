define([
       "jquery" , "underscore" , "backbone"
       , "models/snippet"
       , "collections/snippets" 
       , "views/my-form-snippet"
], function(
  $, _, Backbone
  , SnippetModel
  , SnippetsCollection
  , MyFormSnippetView
){
  return SnippetsCollection.extend({
    model: SnippetModel
    , renderAll: function(){
      return this.map(function(snippet){
        return new MyFormSnippetView({model: snippet}).render("builder");
      })
    }
    , renderAllRendered: function(){
      return this.map(function(snippet){
        return new MyFormSnippetView({model: snippet}).render("render");
      });
    }
  });
});
