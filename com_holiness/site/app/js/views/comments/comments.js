
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
        
        
        hasLoaded: false,
        
        
        events: {
            'keypress #comment-form textarea': 'submitOnEnter',
            'submit #comment-form': 'submitComment'
        },
        
        
        initialize: function (opts) {
            var self = this, 
                loadingGif = new Image(),
                el = document.getElementById('timeline');
            
            // preload image
            loadingGif.src = "components/com_holiness/assets/images/loading.gif";
            
            function handler() {
                if (!self.isElementInViewport(el) || self.hasLoaded) {
                    return false;
                }
                
                self.fetchComments();
            }
            
            // immediately check if end of article is in viewport
            if (el) {
                if (self.isElementInViewport(el) && !self.hasLoaded) {
                    self.fetchComments();
                }
                
                $(window).on('scroll', handler);
            }
            else {
                self.fetchComments();
            }
            
            return self;
        },
        
        
        render: function (collection) {
            var fragment, commentView, hr, self = this,
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
        
        
        
        submitOnEnter: function (event) {
            if (event.which === 13) {
                event.preventDefault();
                this.submitComment();
            }
        },      
        
        
        
        submitComment: function (event) {
            
            if (event) {
                event.preventDefault();
            }
            
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
            
            view.$el.hide();
            self.$('.comments-list').prepend(view.render().$el);
            view.$el.slideDown('slow');
            
            self.send(data, function (error, id) {
                if(!error) {
                    noty({text: 'Comment saved!', type: 'success'});
                    model.set({id: id});
                }
                else {
                    noty({text: 'Comment not saved!', type: 'error'});
                }
            });
            
           document.forms['comment-form'].reset();
        },
        
    
        fetchComments: function () {
            var self = this;
            
            // show loading gif
            self.$el.html('<p style="text-align: center"><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></p>');
            
            // fetch comments from server
            self.collection.fetch({
                success: function (collection, response, options) {
                    self.render(collection);
                    self.collection.trigger('loaded', collection.length);
                    self.hasLoaded = true;                        
                },
                error: function (collection, response, options) {
                    self.render(collection);
                    self.hasLoaded = true;
                }
            });
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
        },
        

        isElementInViewport: function (el) {
            var rect = el.getBoundingClientRect();
        
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= $(window).height() &&
                rect.right <= $(window).width() 
            );
        }        
    });
    
    return CommentsView;
});
