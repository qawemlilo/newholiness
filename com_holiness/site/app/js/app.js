

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
    "views/home",
    "views/members",
    "views/search",
    "views/user",
    "router",
    "bootstrap"
], function($, _, Backbone, UsersCollection, TimelineCollection, CommentsCollection, CommentsView, TimelineView, PostBox, Home, MembersView, Search, User, Router) {
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
            
            var search = App.views.search = new Search(); 
            
            var home = App.views.home = new Home();
            
            var members = App.collections.members = new UsersCollection();
            var membersView = App.views.members = new MembersView({collection: members});
            
            if (!id) {
                var timelineView = new TimelineView({
                    collection: new TimelineCollection()
                });
                timelineView.collection.fetch({
                    success: function (collection, response, options) {
                        timelineView.loadMore();
                    }
                });
            
                var postBox = App.views.postBox = new PostBox({collection: timelineView.collection});

                var user = App.views.user = new User({collection: members});
            }
            else {
                console.log('devotion view');
                var commentsCollection = new CommentsCollection();
                commentsCollection.url = 'index.php?option=com_holiness&task=user.getcomments&id=' + id;
            
                var comments = new CommentsView({
                    collection: commentsCollection
                });                 
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
