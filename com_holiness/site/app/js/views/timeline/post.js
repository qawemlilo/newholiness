
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
    
        tagName: 'div',
        
        
        className: 'post-page',
        
    
        id: 'user-post',
        
        
        template: _.template(Template),
        
        
        events: {
            'click button.plusoneButton': 'plusOne',
            'click button.iprayedbutton': 'iHavePrayed'
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
            
            self.listenToOnce(self.collection, 'render', function (postid) {
                self.render(postid);
            });
        },
        
        
        render: function (postid) {
            var self = this,
                ts = (new Date()).getTime();
            
            if (self.collection && self.collection.length > 0 && self.collection.get(postid)) {
                self.showView(postid, ts);
                
                // scroll to top
                $('html, body').stop().animate({
                    'scrollTop': 0 // - 200px (nav-height)
                }, 200, 'swing');
            }
            else {
                self.collection.fetch({
                    success: function () {
                        self.collection.trigger('render', postid);                      
                    }            
                });
            }
            
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
        
        
        showView: function (id, ts) {
            var self = this,
                model = self.collection.get(id),
                data,
                commentsView;
            
            self.ts = ts;
            self.model = new Model(model.toJSON());
            data = self.model.toJSON();            
            data.ts = self.timeAgo(data.ts);
            data.commentsProp = ts;
            data.currentuser = self.user.toJSON();

            self.$el.html(self.template(data));
            
            self.listenTo(self.model, 'change:plusones',  function (model, plusones) {
                self.handleChanges(model, plusones);
            });
            
            self.getPlusones(function(error){});
            commentsView = self.showComments(id);
            
            // insert comment into the page
            self.$('#timeline').html(commentsView.el);
        },
        
        
        showComments: function (id) {
            var comments =  new Comments(), commentsView, self = this;
            
            //create a url that points to this post's comments
            comments.url = 'index.php?option=com_holiness&task=comments.getcomments&tp=' + self.model.get('posttype') + '&id=' + id;            
            commentsView = new CommentsView({collection: comments, model: self.model});
            
            // once comments have been fetched
            commentsView.collection.on('loaded', function (total) {
               self.$('#postcomments').text(total); // update the comments counter
            });
            
            return commentsView;
        },
        
        
        handleChanges: function (model, plusones) {
            var self = this,
                plusonesHtml = '<ul class="unstyled">',
                prayedHtml = '<ul class="unstyled">',
                posttype = model.get('posttype'),
                prayed = 0;
                
            _.each(plusones, function (plusone) {
                if (plusone) {
                    if (posttype === 'prayerrequest') {
                       if (parseInt(plusone.prayed, 10) === 1) {
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
        
        
        iHavePrayed: function(event) {
            event.preventDefault();
            
            var self = this, data = {};
            
            data.postid = this.model.get('id');
            data.post_type = this.model.get('posttype');
            
            self.sendPrayer(data); 
            
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
        },
        
        
        sendPrayer: function(data) {
            var self = this, 
                plusones = [], 
                url = 'index.php?option=com_holiness&task=posts.ihaveprayed';
            
            $.post(url, data)
            .done(function(data){
                _.each(self.model.get('plusones'), function (plusone) {
                    if (+(plusone.userid) === +(HolinessPageVars.id)) {
                        plusone.prayed = 1;
                    }
                    plusones.push(plusone);
                });
                
                plusones.push(false);
                self.model.set({'plusones': plusones});
                
                noty({text: 'Amen!', type: 'success'});
            })
            
            .fail(function () {
               noty({text: 'Already saved', type: 'error'});
            });    
        }       
    });
    
    return Post;
});
