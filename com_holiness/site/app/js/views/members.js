
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
            
            self.listenTo(self.collection, 'reset', self.render);
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function (collection, response, options) {
                    self.collection.getUsers(12);
                }
            });
            
            return self;
        },

        
        render: function () {
            var fragment = document.createDocumentFragment(), userView;

            
            this.collection.forEach(function (model) { 
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
