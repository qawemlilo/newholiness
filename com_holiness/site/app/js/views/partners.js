
define(["jquery", "underscore", "backbone", "views/partner"], function($, _, Backbone, PartnerView) {
    var PartnersView = Backbone.View.extend({
    
        tagName: 'ul',
        
        
        className: 'unstyled',

        
        initialize: function (options) {
            this.parent = options.parent;
            this.collection = options.collection;
            
            this.$el.html('<li><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></li>');
            
            this.listenTo(this.parent, 'showpartners', this.fetchPartners);
            
            return this;
        },

        
        render: function (error) {
            var fragment = document.createDocumentFragment(), pView;

            if (error) {
                this.$el.parent().html('<div style="margin:0px 0px 10px 10px">Devotion partners not found.</div>');
                
                return;
            }
            
            this.collection.forEach(function (model) { 
                pView = new PartnerView({
                    model: model
                });
                
                fragment.appendChild(pView.render().el);
            });
            
            this.$el.empty().append(fragment);

            return this;
        },


        fetchPartners: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=user.getpartners&id=' + id;
            
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
    
    return PartnersView;
});
