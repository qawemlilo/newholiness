
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/comments",   
    "views/devotions/comments",
    "models/post",
    "text!tmpl/post.html",
    "moment"
], function ($, _, Backbone, Comments, CommentsView, Post, Template) {
    "use strict";
    
    var UserView = Backbone.View.extend({
    
        el: '#user-post',
        
        template: _.template(Template),
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;   
        },
        
        
        render: function (id) {
            var self = this, 
                comments =  new Comments(), 
                model = this.collection.get(id).toJSON(),
                data;

            self.$el.empty();
            
            this.model = new Post(model);
            
            data = this.model.toJSON();
            
            comments.url = 'index.php?option=com_holiness&task=user.getpartners&id=243';
            
            data.ts = this.timeAgo(data.ts);

            this.$el.append(this.template(data));
            this.$el.removeClass('hide');
            
            self.comments = new CommentsView({
                collection: comments
            });
                
            // scroll to top
            $('html, body').stop().animate({
                'scrollTop': 0 // - 200px (nav-height)
            }, 200, 'swing');
            
            return self;
        },
        
        
        timeAgo: function (ts) {
            var ago;
            
            if (ts) {
                ago = moment.unix(parseInt(ts, 10)).fromNow();
            }
            else {
                ago = moment(new Date().getTime()).fromNow();
            }
            
            return ago;     
        }      
    });
    
    return UserView;
});
