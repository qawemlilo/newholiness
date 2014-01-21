
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/timeline/postbox",
    "views/timeline/posts",
    "views/timeline/post",
    "views/user/user",
], function ($, _, Backbone, PostBox, Posts, Post, User) {
    "use strict";
    
    var Container =  Backbone.View.extend({
    
        el: '#app-container',
        
        
        collections: {},
        
        
        initialize: function (opts) {
            var self = this, user;
            
            self.user = opts.user;
            self.collections.users = opts.users;
            self.collections.timeline = opts.timeline;
        },
        
        
        
        renderHome: function () {
            var postBox = new PostBox(),
                timeLine = new Posts({collection: this.collections.timeline, user: this.user});
                
            if (timeLine.collection.length < 1) {   
                timeLine.collection.fetch({
                    remove: false,
                    success: function (collection, response, options) {
                        timeLine.collection.pushCounter();
                    }
                });
            }
            
            this.$el.empty();
            this.$el.append(postBox.render().el);
            this.$el.append(timeLine.render().el);
        },
        
        
        renderPost: function (id) {
            var post = new Post({collection: this.collections.timeline, user: this.user});
            
            this.$el.empty();

            this.$el.append(post.render(id).el);
        },
        
        
        renderProfile: function (id) {
            var user = new User({collection: this.collections.users, user: this.user});
            
            this.$el.empty();

            this.$el.append(user.render(id).el);
        }
    });
    
    return Container;
});
