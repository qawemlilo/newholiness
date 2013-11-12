
define([
    "jquery",
    "underscore", 
    "backbone", 
    "views/timelineitem"
], function ($, _, Backbone, TimelineItemView) {
    "use strict";
    
    var Timeline =  Backbone.View.extend({
    
        el: '#timeline',
        
        
        events: {
            "click .btn-block": "loadMore"
        },
        
        
        initialize: function () {
            this.listenTo(this.collection, "reset", this.render);
            this.listenTo(this.collection, "add", this.render);
            this.$('.dropdown-toggle').dropdown();
        },
        
        
        render: function () {
            var fragment = this.viewAll();
            
            $('.timeline-item, .btn-block').remove();
            this.$el.append(fragment);
            
            return this;                
        },
        
        
        
        
        viewAll: function () {
            var fragment = document.createDocumentFragment(), button = document.createElement('button');
        
            this.collection.forEach(function (postModel) { 
                var postView = new TimelineItemView({model: postModel});
                //console.log(postModel);
                fragment.appendChild(postView.render().el);
            });
            
            button.className = "btn btn-block btn-success";
            button.innerHTML = "Load More";
            fragment.appendChild(button);
            
            return fragment;
        },
        
        
        
        loadMore: function (e) {
            this.collection.getMore();
        }
    });
    
    return Timeline;
});
