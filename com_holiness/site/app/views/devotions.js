
require([
    "jquery", 
    "underscore", 
    "backbone", 
    "../collections/devotions", 
    "../views/devotion"
], function($, _, Backbone, Devotions, DevotionView) {
    var DevotionsView = Backbone.View.extend({
    
        tagName: 'ul',
        
        
        className: 'unstyled',
        
        
        initialize: function (options) {
            this.parent = options.parent;
            this.collection = new Devotions();
            
            this.$el.html('<li><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></li>');
            
            this.listenTo(this.parent, 'showdevotions', this.fetchDevotions);
            //this.listenTo(this.collection, 'reset', this.renderPage);
            
            return this;
        },
        
        
        render: function (error) {
            var fragment = document.createDocumentFragment(), view;
            
            if (error) {
                this.$el.parent().html('<div style="margin:0px 0px 10px 10px">Devotions not found.</div>');
                
                return;
            }
            
            //this.collection.init();
            
            this.collection.forEach(function (model) {
                view = new DevotionView({
                    model: model
                });
                
                fragment.appendChild(view.render().el);
            });
            
            this.$el.empty().append(fragment);
  
            return this;
        },
        
        
        renderPage: function () {
            var fragment = document.createDocumentFragment(), view;
            
            if (!(this.collection.length > 0)) return;
            
            this.collection.forEach(function (model) {
                view = new DevotionView({
                    model: model
                });
                
                fragment.appendChild(view.render().el);
            });
            
            this.$el.empty().append(fragment);
  
            return this;
        },
        

        
        fetchDevotions: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=devotion.getdevotions&id=' + id;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function () {
                    self.render(false);                    
                },
                
                error: function () {
                    self.render(true);
                }
            });        
        }        
    });
    
    return DevotionsView;
});
