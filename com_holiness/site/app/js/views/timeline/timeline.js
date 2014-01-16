
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/timeline/timelineitem"
], function ($, _, Backbone, TimelineItemView, Me) {
    "use strict";
    
    var Timeline =  Backbone.View.extend({
    
        el: '#timeline-content',
        
        
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
            this.$('.timeline-content-items').empty();
            this.viewAll();
            
            return this;                
        },
        
        
        
        
        addOne: function (model) {
            var self = this;
            
            var view = new TimelineItemView({model: model, user: self.user}),
                el = view.render();
            
            el.$el.hide();

            this.$('.timeline-content-items').append(el.el);
            el.$el.slideDown('slow');
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
    
    return Timeline;
});
