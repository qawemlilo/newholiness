    
define(["jquery", "underscore", "backbone", "bootstrap"], function($, _, Backbone) {
    "use strict";
    
    var Nav = Backbone.View.extend({

        el: '#mainNavigation',
        
        
        events: {
            'click .ddowns': 'handleClick'
        },
        
        
        initialize: function (opts) {
            var self = this;
            
            $('.ddowns').popover({'trigger': 'click'});
        },


        handleClick: function (event) {
            $('.ddowns').not(event.currentTarget).popover('hide'); //all but this
            $(event.currentTarget).find("span.noti-indicator").remove();
            
            return false;   
        }        
    });
    
    return Nav;
});
