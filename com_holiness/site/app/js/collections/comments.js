
define(["collections/backbone-fetchcache", "models/comment"], function(Backbone, Comment) {
    "use strict";
    
    var Comments = Backbone.Collection.extend({
        model: Comment
    });
      
    return Comments;
});
