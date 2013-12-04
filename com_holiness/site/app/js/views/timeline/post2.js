
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/comments",   
    "views/devotions/comments",
    "models/post",
    "text!tmpl/post.html",
    "moment"
], function ($, _, Backbone, Comments, CommentsView, Model, Template) {
    "use strict";
    
    var Post = Backbone.View.extend({
    
        el: '#user-post',
        
        template: _.template(Template),
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;   
        },
        
        
        render: function (id) {
            var self = this, 
                comments, 
                model = self.collection.get(id),
                ts = (new Date()).getTime(),
                data;
            
            self.model = new Model(model.toJSON());
            data = self.model.toJSON();            
            data.ts = self.timeAgo(data.ts);
            data.commentsProp = ts;
            data.currentuser = self.user.toJSON();

            self.$el.html(self.template(data));
            self.$el.removeClass('hide');
            
            comments =  new Comments();
            comments.url = 'index.php?option=com_holiness&task=user.getcomments&id=243';            
            self.comments = new CommentsView({el: '#myfriendscomments', collection: comments, ts: ts});

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
    
    return Post;
});
