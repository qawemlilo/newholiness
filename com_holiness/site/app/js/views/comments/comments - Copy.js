
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/devotions/comment",
    "wordlimit"
], function ($, _, Backbone, CommentView) {
    "use strict";
    
    var CommentsView = Backbone.View.extend({
    
        el: '#commentscontainer',
        
        initialize: function (opts) {
            var self = this;
            
            // the commenting system for posts generates unique id for the container 
            if (opts && opts.ts) {
                self.$('#comments_' + opts.ts).wordLimit({
                    counterDiv: '#chars_' + opts.ts
                });            
            }
            else {
                self.$('#commentsbox').wordLimit({
                    counterDiv: '#chars'
                });
            }
                       
            self.collection.fetch({
                success: function (collection, response, options) {
                    self.render(); 
                    if (opts && opts.ts) {
                        self.$("#postcomments").text(collection.length); 
                    }
                                     
                }
            });
            
            return this;
        },
        
        
        
        
        render: function () {
            var fragment = document.createDocumentFragment(), commentView, hr;
            
            if (this.collection.length > 0) {
                hr = document.createElement('hr');
                
                fragment.appendChild(hr);
            }
            
            this.collection.forEach(function (model) { 
                commentView = new CommentView({
                    model: model
                });
                
                fragment.appendChild(commentView.render().el);
            });
            
            this.$el.html(fragment);
            
            return this;
        }       
    });
    
    return CommentsView;
});
