    
define(["jquery", "underscore", "backbone", "bootstrap"], function($, _, Backbone) {
    "use strict";
    
    var Nav = Backbone.View.extend({

        el: '#mainNavigation',
        
        
        activePopUp: false,
        
        
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
            if (this.activePopUp) {
                this.activePopUp.popover('hide');
            }
            
            var currentElem = $(event.currentTarget);
            
            // let us keep a record of this popover
            this.activePopUp = currentElem;
            
            // let us remove highlighting on popover
            currentElem.find("span.noti-indicator").empty().addClass('hide');        
        }
    });
    
    return Nav;
});
