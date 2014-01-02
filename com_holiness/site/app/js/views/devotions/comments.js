
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/devotions/comment",
    "wordlimit"
], function ($, _, Backbone, CommentView) {
    "use strict";

    $.toUpperFirst = $.toUpperFirst || function(txt) {
        var txtArr = txt.toLowerCase().split(" "),
        words = [];

        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1));  
        });
        
        return words.join(" ");
    };
    
    var CommentsView = Backbone.View.extend({
    
        el: $('#commentscontainer'),
        
        initialize: function (opts) {
            var self = this;
            
            // the commenting system for posts generates unique id for the container 
            if (opts && opts.ts) {
                $('#comments_' + opts.ts).wordLimit({
                    counterDiv: '#chars_' + opts.ts
                });            
            }
            else {
                $('#commentsbox').wordLimit({
                    counterDiv: '#chars'
                });
            }
                       
            self.collection.fetch({
                success: function (collection, response, options) {
                    self.render();                    
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
