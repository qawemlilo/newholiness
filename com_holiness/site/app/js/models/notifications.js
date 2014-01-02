
define(["backbone"], function(Backbone) {
    "use strict";
    
    var Notification = Backbone.Model.extend({
        defaults: {
            from: {}, 
            type: "partnerrequest"
        }
    });
      
    return Notification;
});
