
define([
    "jquery",
    "underscore", 
    "backbone",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone) {
    "use strict";
    
    var Devotion = Backbone.View.extend({
    
        el: '#devbuttons',
        
        events: {
            'click button#adddevotionauthor': 'addPartner'
        },
        
        
        initialize: function (opts) {
            this.id = opts.id;
        },
        
        
        addPartner: function (event) {
            event.preventDefault();
            
            var self = this, model;
            
            model = self.collection.get(self.id);
            
            model.addPartner(function(err, data){
                self.$('button.add-partner').off().addClass('disabled');
                
                if (!err) {
                    noty({text: 'Your request has been sent!', type: 'success'});
                }
                else {
                    noty({text: 'You have already sent that user a request', type: 'error'});
                }
            });
        }       
    });
    
    return Devotion;
});
