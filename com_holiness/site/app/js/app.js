

define([
    "jquery", 
    "underscore", 
    "backbone",
    "collections/users",
    "collections/timeline",
    "collections/comments",
    "views/comments",
    "views/timeline",
    "views/postbox",
    "views/members",
    "views/search",
    "router",
    "bootstrap"
], function($, _, Backbone, UsersCollection, TimelineCollection, CommentsCollection, CommentsView, TimelineView, PostBox, MembersView, Search, Router) {
    "use strict";
    
    var App = {
        init: function (id) {
            $('.ddowns').on('click', function(e) {
                $('.ddowns').not(this).popover('hide'); //all but this
                $(this).find("span.noti-indicator").remove();
                return false;
            }).popover({
                'trigger': 'click'
            });
            
            
            // Collections
            var usersCollection = App.collections.users = new UsersCollection();
            
            // Views
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
