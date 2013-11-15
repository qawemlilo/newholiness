
define(["collections/backbone-fetchcache", "models/user"], function(Backbone, User) {
    "use strict";
    
    var Partners = Backbone.Collection.extend({
        model: User      
    });
    
    return Partners;
});
