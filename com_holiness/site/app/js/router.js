
define(["backbone", "views/main"], function(Backbone, Main) {
    var Router = Backbone.Router.extend({
    
        routes: {
            '': 'home',
            'users/:id': 'loadProfile',
            'post/:id': 'loadPost'
        },
        
        
        initialize: function (app) { 
            this.view = new Main({
                users: app.collections.users, 
                user: app.user, 
                timeline: app.collections.timeline
            });
        },
        
        
        home: function () {
            this.view.render('home');
        },
        
        
        loadProfile: function (userid) {
            this.view.render('profile', userid);
        },
        
        
        loadPost: function (postid) {
            this.view.render('post', postid);
        }
    });
    
    return Router;
});  
