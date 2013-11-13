
define([
    "jquery",
    "underscore", 
    "backbone",
    "views/member",
    "backboneCache"
], function ($, _, Backbone, UserView, backboneCache) {
    var MembersView = Backbone.View.extend({
    
        el: $('#members-list'),

        
        initialize: function () { 
            var self = this;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function (collection, response, options) {
                   self.render(self.collection.getUsers(12));
                   self.collection.trigger('complete');
                }
            });
            
            return self;
        },

        
        render: function (itemlist) {
            var fragment = document.createDocumentFragment(), userView, counter = 0;

            
            itemlist.forEach(function (model) {
                userView = new UserView({
                    model: model
                });
                
                fragment.appendChild(userView.render().el);
            });
            
            this.$el.html(fragment);
            
            return this;
        }       
    });
    
    return MembersView;
});
