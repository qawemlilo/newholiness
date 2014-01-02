
define(["jquery", "backbone"], function($, Backbone) {
    "use strict";
    
    var Request = Backbone.Model.extend({
        defaults: {
            imgext: "",
            userid: "",
            name: ""
        },
        
        
        respond: function(res, id, partnerid, fn) {
            $.post('index.php?option=com_holiness&task=home.partnerresponse', {res: res, id: id, partnerid:partnerid})
            .done(function(data){
                fn(false, data);
            })
            .fail(function () {
               fn(true);
            });    
        }
    });
      
    return Request;
});
