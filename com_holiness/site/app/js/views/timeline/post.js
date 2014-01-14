
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/comments",   
    "views/comments/comments",
    "models/post",
    "models/comment",
    "views/comments/comment",
    "text!tmpl/post.html",
    "noty",
    "notyTheme",
    "notyPosition",
    "moment"
], function ($, _, Backbone, Comments, CommentsView, Model, Comment, CommentView, Template) {
    "use strict";
    
    var Post = Backbone.View.extend({
    
        el: '#user-post',
        
        template: _.template(Template),
        
        
        events: {
            'submit form': 'submitComment',
            'click button.plusoneButton': 'plusOne'
        },
        
        
        postMsges: {
            'prayerrequest': 'promises to pray for you',
            'testimony': 'praises God for your testimony',
            'prophecy': 'is part of this move of God',
            'revelation': 'declares this revelation to be powerful'
        },
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;
            
            if (self.model) {
                self.model.off();
                console.log('model existed');
            }
        },
        
        
        render: function (id) {
            var self = this, 
                comments, 
                model = self.collection.get(id),
                ts = (new Date()).getTime(),
                data;
            
            self.ts = ts;
            self.model = new Model(model.toJSON());
            data = self.model.toJSON();            
            data.ts = self.timeAgo(data.ts);
            data.commentsProp = ts;
            data.currentuser = self.user.toJSON();

            self.$el.empty().html(self.template(data));
            self.$el.removeClass('hide');
            
            self.model.on('change:plusones',  function (model, plusones) {
                self.handleChanges(model, plusones);
            });
            
            comments =  new Comments();
            comments.url = 'index.php?option=com_holiness&task=comments.getcomments&tp=' + self.model.get('posttype') + '&id=' + id;            
            self.comments = new CommentsView({el: '#myfriendscomments', collection: comments, ts: ts});
            
            self.getPlusones(function (error) {
               // do something
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
        },
        
        
        
        
        handleChanges: function (model, plusones) {
            var self = this,
                plusonesHtml = '<ul class="unstyled">',
                prayedHtml = '<ul class="unstyled">',
                posttype = model.get('posttype'),
                prayed = 0;
                
            _.each(plusones, function (plusone) {
                if (posttype === 'prayerrequest') {
                   if(parseInt(plusone.prayed, 10) === 1) {
                      prayed += 1;
                      prayedHtml += '<li><a href="#/users/' + plusone.userid + '">' + plusone.name + '</a> has prayed for you</li>';
                   }
                   else {
                      plusonesHtml += '<li><a href="#/users/' + plusone.userid + '">' + plusone.name + '</a> ' + self.postMsges[posttype] + '</li>';        
                   }
                }
                else {
                   plusonesHtml += '<li><a href="#/users/' + plusone.userid + '">' + plusone.name + '</a> ' + self.postMsges[posttype] + '</li>';
                }
            });
                
            plusonesHtml += '</ul>';
                
            self.$('#plusones-' + posttype).html(plusonesHtml);
            self.$('#willpray').text(plusones.length - prayed); 
                
            if (posttype === 'prayerrequest' && prayed) {
                prayedHtml += '</ul>';
                self.$('#plusones-prayed').html(prayedHtml);
                self.$('#haveprayed').text(prayed);
            } 
        },
        
        
        
        
        submitComment: function (event) {
        
            event.preventDefault();
            
            var data = this.formToObject("#form_" + this.ts);
            var model = new Comment({
                ts: false, 
                imgext: HolinessPageVars.imgext, 
                userid: data.userid, 
                comment: data.txt, 
                name: HolinessPageVars.name
            });
            
            data.name = HolinessPageVars.name;

            var view = new CommentView({model: model});
            
            $('#myfriendscomments').append(view.render().el);
            
            this.send(data, function (error, res) {
                if(!error) {
                    noty({text: 'Comment saved!', type: 'success'});
                }
                else {
                    noty({text: 'Comment not saved', type: 'error'});
                }
            });
            
           document.forms['form_' + this.ts].reset();
        },
        
    
        formToObject: function (form) {
            var formObj = {}, arr = $(form).serializeArray();
        
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
        
        
        getPlusones: function(fn) {
            var self = this, data = {};
            
            data.id = this.model.get('id');
            data.tp = this.model.get('posttype');
            
            $.get('index.php?option=com_holiness&task=posts.getplusones', data)
            .done(function(data){
                self.model.set({plusones: data});
                fn(false);
            })
            .fail(function () {
               fn(true);
            });    
        },
        
        
        plusOne: function(event) {
            event.preventDefault();
            
            var self = this, data = {};
            
            data.postid = this.model.get('id');
            data.post_type = this.model.get('posttype');
            
            self.sendplusOne(data); 
            
            return false;   
        },
        
        
        sendplusOne: function(data) {
            var self = this, plusones = [], type, url;
            
            type = self.model.get('posttype');
            
            if (type === 'prayerrequest') {
                url = 'index.php?option=com_holiness&task=posts.willpray';
            }
            else {
                url = 'index.php?option=com_holiness&task=posts.plusone';
            }
            
            $.post(url, data)
            .done(function(data){
                _.each(self.model.get('plusones'), function (plusone) {
                    plusones.push(plusone);
                });
                plusones.push({'userid': HolinessPageVars.id, 'name': HolinessPageVars.name, 'prayed': 0});
                self.model.set({'plusones': plusones});
                
                noty({text: 'Saved!', type: 'success'});
            })
            
            .fail(function () {
               noty({text: 'Already saved', type: 'error'});
            });    
        }      
    });
    
    return Post;
});
