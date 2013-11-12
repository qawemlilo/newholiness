
define(["underscore", "backbone"], function(_, Backbone) {
    var Devotion = Backbone.Model.extend({
        defaults: {
            id: 0, 
            theme: ""
        }
    });
    
    return Devotion;
});
