    
require(["jquery", "underscore", "backbone"], function($, _, Backbone) {    
    var HomeView = Backbone.View.extend({

        el: '#timeline',

        
        render: function () {
            this.$el.removeClass('hide');
            
            return this;
        }       
    });
    
    return HomeView;
});
