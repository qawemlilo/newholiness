
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/timeline/timelineitem",
    "text!tmpl/timeline/timeline.html"
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
            self.listenTo(self.collection, "reset", self.viewAll);
            
            self.$('.dropdown-toggle').dropdown();
        },
        
        
        render: function () {
            this.$el.html(this.template({}));
            this.viewAll();
            
            return this;                
        },
        
        
        
        
        addOne: function (model) {
            var self = this,
                view = (new TimelineItemView({model: model, user: self.user})).render();

            this.$('.timeline-content-items').append(view.$el);
        },
        
        
        
        
        viewAll: function () {
            var self = this;
        
            self.collection.forEach(function (postModel) { 
                self.addOne(postModel);
            });
        },
        
        
        
        loadMore: function (event) {
            event.preventDefault();
            
            var self = this, button = $(event.currentTarget);
            
            button.button('loading');

            self.collection.fetch({
                remove: false,
                
                success: function (collection, response, options) {
                    self.collection.pushCounter();
                    button.button('reset');
                },
                error: function (collection, response, options) {
                    button.button('reset');
                }
            });
        }
    });
    
    return Posts;
});
