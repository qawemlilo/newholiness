
define(["backbone", "views/main"], function(Backbone, Main) {
    var Router = Backbone.Router.extend({
    
        routes: {
            '': 'home',
            'users/:id': 'profile',
            'post/:id': 'post'
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
        
        
        profile: function (userid) {
            this.view.render('profile', userid);
        },
        
        
        post: function (postid) {
            this.view.render('post', postid);
        }
    });
    
    return Router;
});  
