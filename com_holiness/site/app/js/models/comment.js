
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Comment = Backbone.Model.extend({
        defaults: {
            id: '',
            userid: '', 
            ts: '', 
            comment: '',
            'comment_type': '', 
            imgext: '', 
            name: '',
            amens: ''
        }
    });
      
    return Comment;
});
