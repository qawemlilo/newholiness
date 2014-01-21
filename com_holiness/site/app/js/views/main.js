
define([
    "backbone", 
    "views/timeline/postbox",
    "views/timeline/posts",
    "views/timeline/post",
    "views/user/user",
], function (Backbone, PostBox, Posts, Post, User) {
    "use strict";
    
    var Container =  Backbone.View.extend({
    
        el: '#app-container',
        
        
        collections: {},
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;
            self.collections.users = opts.users;
            self.collections.timeline = opts.timeline;
        },
        
        
        render: function (view, itemId) {
            var self = this;
            
            self.$el.empty();
            
            switch (view) {
                case 'home': 
                    var postBox = new PostBox(),
                        timeLine = new Posts({collection: self.collections.timeline, user: self.user});
                        
                    if (timeLine.collection.length < 1) {   
                        timeLine.collection.fetch({
                            remove: false,
                            success: function (collection, response, options) {
                                timeLine.collection.pushCounter();
                            }
                        });
                    }
                    
                    self.$el.append(postBox.render().el);
                    self.$el.append(timeLine.render().el);
                break;
                
                
                case 'post': 
                    var post = new Post({collection: self.collections.timeline, user: self.user});
 
                    self.$el.append(post.render(itemId).el);
                break;
                
                
                case 'profile': 
                    var user = new User({collection: self.collections.users, user: self.user});
                    
                    self.$el.append(user.render(itemId).el);
                break;
            }
            
            return self;
        }
    });
    
    return Container;
});
