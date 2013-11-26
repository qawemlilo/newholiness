
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
            "click .btn-block": "loadMore"
        },
        
        
        initialize: function (opts) {
            var self = this, user;
            
            self.user = opts.user;
            
            self.listenTo(self.collection, "reset", self.render);
            self.listenTo(self.collection, "add", self.addOne);
            self.$('.dropdown-toggle').dropdown();
        },
        
        
        render: function () {
            var fragment = this.viewAll();
            
            this.$('.timeline-item, .btn-block').remove();
            this.$el.empty().append(fragment);
            
            return this;                
        },
        
        
        
        
        addOne: function (model) {
            var self = this;
            
            var view = new TimelineItemView({model: model, user: self.user}),
                el = view.render();
            
            el.$el.hide();

            this.$el.prepend(el.el);
            el.$el.slideDown('slow');
        },
        
        
        
        
        viewAll: function () {
            var fragment = document.createDocumentFragment(), 
                button = document.createElement('button'),
                self = this;
        
            this.collection.forEach(function (postModel) { 
                var postView = new TimelineItemView({model: postModel, user: self.user});

                fragment.appendChild(postView.render().el);
            });
            
            button.className = "btn btn-block btn-success";
            button.innerHTML = "Load More";
            fragment.appendChild(button);
            
            return fragment;
        },
        
        
        
        loadMore: function (event) {
            if (event) {
                event.preventDefault();
            }
            
            this.collection.getMore();
        }
    });
    
    return Timeline;
});
