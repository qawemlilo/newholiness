
define([
    "jquery", 
    "underscore", 
    "backbone",
    "collections/users",
    "collections/timeline",
    "collections/comments",
    "views/navigation/nav",
    "views/navigation/search",
    "views/devotions/comments",
    "views/timeline/timeline",
    "views/timeline/postbox",
    "views/panel/members",
    "router"
], function($, _, Backbone, UsersCollection, TimelineCollection, CommentsCollection, Nav, Search, CommentsView, TimelineView, PostBox, MembersView, Router) {
    "use strict";
    
    var App = {
        init: function (id) {
            // Collections
            var usersCollection = App.collections.users = new UsersCollection();
            
            // Views
            App.views.nav = new Nav();
            App.views.search = new Search({collection: usersCollection}); 
            App.views.members = new MembersView({collection: usersCollection});
            
            // if id not defined (which means we are on the home page)
            if (!id) {
                var timelineCollection =  App.collections.timeline = new TimelineCollection();
                var timelineView = new TimelineView({collection: timelineCollection});
                
                timelineView.collection.fetch({
                    success: function (collection, response, options) {
                        timelineView.loadMore();
                    }
                });
            
                App.views.postBox = new PostBox({collection: timelineCollection});
            }
            
            // if id id defined (which means we are on the devotion page)
            else {
                var commentsCollection =  App.collections.comments = new CommentsCollection();
                commentsCollection.url = 'index.php?option=com_holiness&task=user.getcomments&id=' + id;
            
                App.views.comments = new CommentsView({collection: commentsCollection});                 
            }            
            
            App.router = new Router(App);
            Backbone.history.start();
            
            return this;
        },
        
        models: {},
        
        views: {},
        
        collections: {},
        
        router: {}
    };    
        
    return App;
});