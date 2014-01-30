
define([
    "jquery",
    "backbone",
    "models/me",
    "collections/users",
    "collections/timeline",
    "collections/comments",
    "views/navigation/requests",
    "views/navigation/search",
    "views/comments/comments",
    "views/devotion/email",
    "models/post",
    "views/panel/members",
    "router"
], function($, Backbone, Me, UsersCollection, TimelineCollection, CommentsCollection, Nav, Search, CommentsView, emailDevotion, Post, MembersView, Router) {
    "use strict";
    
    var App = {
        init: function (id) {
            // Collections
            var usersCollection = new UsersCollection(window.window.hp_members);
            App.collections.users = usersCollection;
            
            App.user = new Me(window.HolinessPageVars);
            App.views.nav = new Nav({collection: usersCollection});
            App.views.search = new Search({collection: usersCollection, user: App.user}); 
            App.views.members = new MembersView({collection: usersCollection});
            
            // if id not defined (which means we are on the home page)
            if (!id) {
                App.collections.timeline = new TimelineCollection(window.hp_timelime);
                App.collections.timeline.pushCounter();
                
                App.router = new Router(App);
                Backbone.history.start();
            }
            
            // if id id defined (which means we are on the devotion page)
            else {
                var author = $('#authorid').val(), 
                    post = new Post({id: id, posttype: 'devotion', userid: author, postid: id});
                
                App.collections.comments = new CommentsCollection();
                App.collections.comments.url = 'index.php?option=com_holiness&task=comments.getcomments&tp=devotion&id=' + id;
                
                App.views.comments = new CommentsView({collection: App.collections.comments,  model: post});
                
                $('#timeline').html(App.views.comments.el);
                
                emailDevotion();
            }            
            
            return this;
        },
        
        models: {},
        
        views: {},
        
        collections: {},
        
        router: {}
    };    
        
    return App;
});
