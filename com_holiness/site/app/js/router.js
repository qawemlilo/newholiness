
define(["jquery", "underscore", "backbone"], function($, _, Backbone) {
    var Router = Backbone.Router.extend({
    
        routes: {
            '': 'home',
            'users/:id': 'loadUser'
        },
        
        initialize: function (app) { 
            this.app = app;
        },
        
        
        home: function () {
            $('.content-display:not(.hide)').addClass('hide');
            this.app.views.home.render();
        },
        
        
        loadUser: function (id) {
            $('.content-display:not(.hide)').addClass('hide');
            this.app.views.user.render(id);
        }
    });
    
    return Router;
});  
