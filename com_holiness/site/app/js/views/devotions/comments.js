
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/devotions/comment"
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
        
        initialize: function () {
            var self = this;
                       
            this.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                prefillSuccess: function (collection, response, options) {
                    self.render();
                },
                
                success: function () {
                    self.render();                    
                }
            });
            
            return this;
        },
        
        render: function () {
            var fragment = document.createDocumentFragment(), commentView, hr;
            
            this.$el.empty();
            
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
