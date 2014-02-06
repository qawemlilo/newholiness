
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/timeline/timelineitem",
    "text!tmpl/timeline/timeline.html",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, TimelineItemView, Template) {
    "use strict";
    
    var Posts =  Backbone.View.extend({
    
        tagName: 'div',
    
    
        id: 'timeline-content',
        
        
        loading: false,
        
        
        className: 'content-display',
        
        
        template: _.template(Template),
        
        
        events: {
            "click .timeline-content-button": "loadMore"
        },
        
        
        initialize: function (opts) {
            var self = this, user;
            
            self.user = opts.user;
            
            self.listenTo(self.collection, "add", self.addOne);
            
            self.$('.dropdown-toggle').dropdown();
        },
        
        
        render: function () {
            this.$el.html(this.template({}));
            this.viewAll();
            
            // if has fetched all items from the server hide loading button
            if (this.collection.isComplete()) {
                this.$('.timeline-content-button').hide();    
            }
            
            return this;                
        },
        
        
        
        
        addNew: function (model) {
         
            var self = this, view;
            
            self.collection.add(model, {silent: true, at: 0});

            view = new TimelineItemView({model: model, user: self.user});
            view.$el.hide();
            self.$('.timeline-content-items').prepend(view.$el);
            view.$el.slideDown('slow');
        },
        
        
        
        
        addOne: function (model) {
            var self = this,
                view = new TimelineItemView({model: model, user: self.user});
                
            self.$('.timeline-content-items').append(view.$el);
        },
        
        
        
        
        viewAll: function () {
            var self = this;
            
            self.collection.forEach(function (postModel) { 
                self.addOne(postModel);
            });
        },
        
        
        
        loadMore: function (event) {
            
            if (event) {
                event.preventDefault();
            }
            
            var self = this, button, notice;
            
            // if its still loading or has fetched all items from the server
            if (self.loading || self.collection.isComplete()) {
                return;
            }
            
            self.loading =  true;
            
            button = $('.timeline-content-button button');
            
            button.button('loading');
            notice = noty({text: 'Loading...', timeout: false, type: 'warning'});

            self.collection.fetch({
                remove: false,
                
                success: function (collection, response, options) {
                    self.collection.pushCounter();
                    button.button('reset');
                    notice.close();
                    self.loading =  false;
                },
                
                error: function (collection, response, options) {
                    self.collection.isComplete(true);
                    self.$('.timeline-content-button').hide(); 
                    button.button('reset');
                    notice.close();
                    self.loading =  false;
                }
            });
        }
    });
    
    return Posts;
});
