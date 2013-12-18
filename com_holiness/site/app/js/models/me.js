
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Me = Backbone.Model.extend({
        defaults: {
            name: "", 
            username: "",
            baseUrl: "",            
            email: "",
            partners: []
        }
    });
      
    return Me;
});
