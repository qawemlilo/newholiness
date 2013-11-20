    
define(["jquery", "underscore", "backbone", "bootstrap"], function($, _, Backbone) {
    "use strict";
    
    var Nav = Backbone.View.extend({

        el: '#mainNavigation',
        
        
        activePopUps: [],
        
        
        events: {
            'click .ddowns': 'handleClick'
        },
        
        
        initialize: function (opts) {
            var self = this;
            
            $('.ddowns').popover({'trigger': 'click'});
        },


        handleClick: function (event) {
            event.preventDefault();
            
            // let use close any open popovers
            if (this.activePopUps.length > 0) {
                this.removePopUps();
            }
            
            var currentElem = $(event.currentTarget);
            
            // let us keep a record of this popover
            this.activePopUps.push(currentElem);
            
            // let us remove highlighting on popover
            currentElem.find("span.noti-indicator").empty().addClass('hide');        
        },


        removePopUps: function () {
            var self = this;
            
            _.each(self.activePopUps, function (popUp) {
                popUp.popover('hide');
            });       
        }
    });
    
    return Nav;
});
