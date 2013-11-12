

define([
    "jquery", 
    "underscore", 
    "backbone",
    "collections/users",
    "collections/timeline",
    "views/timeline",
    "views/postbox",
    "views/home",
    "views/members",
    "views/search",
    "views/user",
    "router",
    "bootstrap"
], function($, _, Backbone, UsersCollection, TimelineCollection, TimelineView, PostBox, Home, MembersView, Search, User, Router) {
    "use strict";
    
    var App = {
        init: function () {
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
            
            var postBox = App.views.postBox = new PostBox();
            var timelineView = new TimelineView({
                collection: new TimelineCollection()
            });
            timelineView.collection.fetch({
                success: function (collection, response, options) {
                    timelineView.loadMore();
                }
            });

            var user = App.views.user = new User({collection: members});            
            
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
