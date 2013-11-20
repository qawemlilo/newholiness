
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Devotion = Backbone.Model.extend({
        defaults: {
            id: 0, 
            theme: ""
        }
    });
    
    return Devotion;
});
