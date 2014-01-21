
define([
    "jquery",
    "underscore", 
    "backbone",
    "models/comment",    
    "views/comments/comment",
    "text!tmpl/comments/comments.html",
    "wordlimit"
], function ($, _, Backbone, CommentModel, CommentView, Template) {
    "use strict";
    
    var CommentsView = Backbone.View.extend({
    
        tagName: 'div',
        
        
        id: 'commentscontainer',
        
        
        template: _.template(Template),
        
        
        events: {
            'submit #comment-form': 'submitComment'
        },
        
        
        initialize: function (opts) {
            var self = this;
                       
            self.collection.fetch({
                success: function (collection, response, options) {
                    self.render(collection);
                    self.collection.trigger('loaded', collection.length);                 
                },
                error: function (collection, response, options) {
                    self.render(collection);                 
                }
            });
            
            self.$el.html('<p style="text-align: center"><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></p>');
            
            return self;
        },
        
        
        render: function (collection) {
            var fragment, 
                commentView, 
                hr, 
                self = this,
                data = {
                    imgext: HolinessPageVars.imgext,
                    userid: HolinessPageVars.id,
                    name: HolinessPageVars.name,
                    posttype: self.model.get('posttype'),
                    author: self.model.get('userid'),
                    postid: self.model.get('id')                   
                },
                template = self.template(data);
            
            
            self.$el.html(template);
            
            if (collection.length > 0) {
                fragment = document.createDocumentFragment();
            
                collection.forEach(function (model) { 
                    commentView = new CommentView({
                        model: model
                    });
                
                    fragment.appendChild(commentView.render().el);
                });
                
                self.$('.comments-list').html(fragment);
            }
            
            self.$('#commentsbox').wordLimit({
                counterDiv: '#chars'
            });
            
            return self;
        },      
        
        
        
        submitComment: function (event) {
        
            event.preventDefault();
            
            var self = this,
                data = self.formToObject(),
                model = new CommentModel({
                    ts: false, 
                    imgext: HolinessPageVars.imgext, 
                    userid: data.userid, 
                    comment: data.txt, 
                    name: data.name
                }),
                view = new CommentView({model: model});
            
            self.$('.comments-list').append(view.render().el);
            
            self.send(data, function (error, res) {
                if(!error) {
                    noty({text: 'Comment saved!', type: 'success'});
                }
                else {
                    noty({text: 'Comment not saved!', type: 'error'});
                }
            });
            
           document.forms['comment-form'].reset();
        },
        
    
        formToObject: function () {
            var formObj = {}, arr = this.$('#comment-form').serializeArray();
        
            _.each(arr, function (fieldObj) {
                if (fieldObj.name !== 'submit') {
                    formObj[fieldObj.name] = fieldObj.value;
                }
            });
        
            return formObj;
        },
        
        
        send: function(data, fn) {
            $.post('index.php?option=com_holiness&task=comments.addcomment', data)
            .done(function(data){
                fn(false, data);
            })
            .fail(function () {
               fn(true);
            });    
        }       
    });
    
    return CommentsView;
});
