
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Comment = Backbone.Model.extend({
        defaults: {
            id: 0, 
            ts: 0, 
            comment: "", 
            imgext: "", 
            name: "",
            amens: ""
        }
    });
      
    return Comment;
});
