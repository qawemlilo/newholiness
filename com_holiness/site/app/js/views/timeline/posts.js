
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
            
            return this;                
        },
        
        
        
        
        addNew: function (model) {
         
            var self = this, view;
            
            self.collection.add(model, {silent: true});

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
            event.preventDefault();
            
            var self = this, button = $(event.currentTarget), notice;
            
            button.button('loading');
            notice = noty({text: 'Loading...', timeout: false, type: 'warning'});

            self.collection.fetch({
                remove: false,
                
                success: function (collection, response, options) {
                    self.collection.pushCounter();
                    button.button('reset');
                    notice.close();
                },
                error: function (collection, response, options) {
                    button.button('reset');
                    notice.close();
                }
            });
        }
    });
    
    return Posts;
});
