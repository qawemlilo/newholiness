
define(["jquery", "underscore", "backbone", "views/user/user", "views/home"], function($, _, Backbone, User, Home) {
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
           
            var home;
            
            if (this.app.views.home) {
                home = this.app.views.home; 
            }
            else {
                home = new Home();
                this.app.views.home = home;
            }
            
            home.render();
        },
        
        
        loadUser: function (id) {
            $('.content-display:not(.hide)').addClass('hide');
            
            var user = new User({collection: this.app.collections.users});
            
            user.render(id);
        }
    });
    
    return Router;
});  
