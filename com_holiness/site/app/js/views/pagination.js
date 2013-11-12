    
define(["jquery", "underscore", "backbone"], function($, _, Backbone) {
    var Pagination = Backbone.View.extend({
    
        tagName: 'ul',
        
        
        className: 'pager',
        

        template: _.template($('#pagination-tpl').text()),

        
        initialize: function (options) {
            this.parent = options.parent;

            this.listenTo(this.parent.collection, 'reset', this.render);
            
            return this;
        },
        
        
        render: function () {
            var prev = this.parent.collection.prev
            var next = this.parent.collection.next;
            
            var template = this.template({prev: prev, nxt: next});
            
            this.$el.empty().html(template);
            
            return this;
        }       
    });
    
    return Pagination;
});
