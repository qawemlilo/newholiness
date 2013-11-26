
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Me = Backbone.Model.extend({
        defaults: {
            name: "", 
            username: "",
            baseUrl: "",            
            email: "",
            partners: []
        },
        
        urlRoot: 'index.php?option=com_holiness&task=user.me'
    });
      
    return Me;
});
