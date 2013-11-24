    
define(["jquery", "underscore", "backbone"], function($, _, Backbone) {    
    var HomeView = Backbone.View.extend({

        el: '#timeline',

        
        render: function () {
            $('#timeline-content, #timeline').removeClass('hide');
            
            return this;
        }       
    });
    
    return HomeView;
});
