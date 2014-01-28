
define([
    "jquery",
    "backbone",
    "models/me",
    "collections/users",
    "collections/timeline",
    "collections/comments",
    "views/navigation/requests",
    "views/navigation/search",
    "views/comments/comments",
    "models/post",
    "views/panel/members",
    "router"
], function($, Backbone, Me, UsersCollection, TimelineCollection, CommentsCollection, Nav, Search, CommentsView, Post, MembersView, Router) {
    "use strict";
    
    var App = {
        init: function (id) {
            // Collections
            var usersCollection = App.collections.users = new UsersCollection();
            
            usersCollection.fetch();
            
            App.user = new Me(HolinessPageVars);
            App.views.nav = new Nav({collection: usersCollection});
            App.views.search = new Search({collection: usersCollection, user: App.user}); 
            App.views.members = new MembersView({collection: usersCollection});
            
            // if id not defined (which means we are on the home page)
            if (!id) {
                App.collections.timeline = new TimelineCollection();
                
                App.router = new Router(App);
                Backbone.history.start();
            }
            
            // if id id defined (which means we are on the devotion page)
            else {
                var author = $('#authorid').val(), 
                    post = new Post({id: id, posttype: 'devotion', userid: author, postid: id});
                
                App.collections.comments = new CommentsCollection();
                App.collections.comments.url = 'index.php?option=com_holiness&task=comments.getcomments&tp=devotion&id=' + id;
                
                App.views.comments = new CommentsView({collection: App.collections.comments,  model: post});
                
                $('#timeline').html(App.views.comments.el);
            }

            $('#myModal').modal({
                keyboard: false,
                show: false
            });
            
            
            function handleForm(event, opts) {
                var self = opts.form,
                    progress = $('form .' + opts.progress),
                    response = $('form .' + opts.response);
                    
                progress.slideDown(function () {
                    $.post(opts.action, $(self).serialize() + '&t=' + (new Date().getTime()) , 'text')
                    
                    .done(function(res) {
                        if (typeof res === 'object') {
                            res = res.message;
                        }
                        
                        progress.slideUp(function () {
                            response.addClass('alert-success').html($('<strong>' + res + '</strong>')).slideDown('slow');
                        });
                          
                        window.setTimeout(function () { 
                            response.slideUp(function () {
                                response.removeClass('alert-success');
                            }); 
                        }, 10 * 1000);
                    })
                    
                    .fail(function(res) {
                        if (typeof res === 'object') {
                            res = res.message;
                        }
                        
                        progress.slideUp(function () {
                            response.addClass('alert-error').html($('<strong>' + res + '</strong>')).slideDown('slow');
                        });
                          
                        window.setTimeout(function () { 
                            response.slideUp(function () {
                                response.removeClass('alert-error');
                            }); 
                        }, 10 * 1000);
                    });
                });
                    
                return false;
            }
            
            
            $('#chgform').on('submit', function (event) {
                return handleForm(event, {
                    form: this,
                    progress: 'passprogress',
                    response: 'passresponse',
                    action: $(this).attr('action')
                });
            });            
            
            return this;
        },
        
        models: {},
        
        views: {},
        
        collections: {},
        
        router: {}
    };    
        
    return App;
});
