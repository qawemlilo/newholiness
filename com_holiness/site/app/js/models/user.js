
define(["jquery", "backbone"], function($, Backbone) {
    "use strict";
    
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        },
        
        
        addPartner: function (fn) {
            var self = this;
            
            self.send(self.get('id'), fn);
        },
        
        
        send: function(id, fn) {
            $.post('index.php?option=com_holiness&task=user.addpartner', {partnerid: id})
            .done(function(data){
                fn(false, data);
            })
            .fail(function () {
               fn(true);
            });    
        }
    });
      
    return User;
});
