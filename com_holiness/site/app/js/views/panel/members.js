
define(["jquery", "underscore", "backbone", "views/panel/member"], function ($, _, Backbone, UserView) {
    "use strict";
    
    var MembersView = Backbone.View.extend({
    
        el: $('#members-list'),
   
   
        fired: false,

        
        initialize: function () { 
            var self = this;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                prefillSuccess: function (collection, response, options) {
                    self.render();
                    
                    // search view waiting for this event to populate auto-fill
                    self.collection.trigger('complete');
                    
                    self.fired = true;
                },
                
                success: function (collection, response, options) {
                    if (!self.fired) {
                        self.render();
                    
                        // search view waiting for this event to populate auto-fill
                        self.collection.trigger('complete');
                        
                        self.fired = true;
                    }
                }
            });
            
            return self;
        },

        
        render: function () {
            var self = this, itemlist, fragment = document.createDocumentFragment(), userView, model;

            itemlist = self.randomArray(12, self.collection.length);
            
            itemlist.forEach(function (key) {
                model = self.collection.at(key);
                
                userView = new UserView({
                    model: model
                });
                
                fragment.appendChild(userView.render().el);
            });
            
            self.$el.html(fragment);
            
            return self;
        },
        

        randomArray: function (size, collectionLength) {
            var temp = [], i, num;
            
            for (i = 0; i < size; i++) {
                num = Math.floor((Math.random() * collectionLength) + 1);
                temp.push(num);
            }
            
            return temp;
        }       
    });
    
    return MembersView;
});
