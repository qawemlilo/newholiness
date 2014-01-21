
define(["backbone", "views/main"], function(Backbone, Main) {
    var Router = Backbone.Router.extend({
    
        routes: {
            '': 'home',
            'users/:id': 'loadUser',
            'post/:id': 'loadPost'
        },
        
        
        initialize: function (app) { 
            this.views = new Main({
                users: app.collections.users, 
                user: app.user, 
                timeline: app.collections.timeline
            });
        },
        
        
        home: function () {
            this.views.renderHome();
        },
        
        
        loadUser: function (id) {
            this.views.renderProfile(id);
        },
        
        
        loadPost: function (id) {
            this.views.renderPost(id);
        }
    });
    
    return Router;
});  
