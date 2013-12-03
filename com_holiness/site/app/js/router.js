
define(["jquery", "underscore", "backbone", "views/user/user", "views/timeline/post", "views/home"], function($, _, Backbone, User, Post, Home) {
    var Router = Backbone.Router.extend({
    
        routes: {
            '': 'home',
            'users/:id': 'loadUser',
            'post/:id': 'loadPost'
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
            
            var user = new User({collection: this.app.collections.users, user: this.app.user});
            
            user.render(id);
        },
        
        
        loadPost: function (id) {
            $('.content-display:not(.hide)').addClass('hide');
            
            var post = new Post({collection: this.app.collections.timeline, user: this.app.user});
            
            post.render(id);
        }
    });
    
    return Router;
});  
