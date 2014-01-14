
define([
    "backbone",
    "models/me",
    "collections/users",
    "collections/timeline",
    "collections/comments",
    "views/navigation/requests",
    "views/navigation/search",
    "views/comments/comments",
    "views/comments/commentbox",
    "views/timeline/timeline",
    "views/timeline/postbox",
    "views/panel/members",
    "router"
], function(Backbone, Me, UsersCollection, TimelineCollection, CommentsCollection, Nav, Search, CommentsView, CommentBox, TimelineView, PostBox, MembersView, Router) {
    "use strict";
    
    var App = {
        init: function (id) {
            // Collections
            var usersCollection = App.collections.users = new UsersCollection();
            
            usersCollection.fetch();
            
            App.user = new Me(HolinessPageVars);
            App.views.nav = new Nav({collection: usersCollection});
            App.views.search = new Search({collection: usersCollection, user: App.user}); 
            App.views.members = new MembersView({collection: usersCollection});
            
            // if id not defined (which means we are on the home page)
            if (!id) {
                var timelineCollection =  App.collections.timeline = new TimelineCollection();
                var timelineView = new TimelineView({collection: timelineCollection, user: App.user});
                
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
                commentsCollection.url = 'index.php?option=com_holiness&task=comments.getcomments&tp=devotion&id=' + id;
            
                App.views.comments = new CommentsView({collection: commentsCollection}); 
                App.views.commentbox = new CommentBox({collection: commentsCollection});                
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
