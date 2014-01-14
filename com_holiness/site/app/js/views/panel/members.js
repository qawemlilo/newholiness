
define(["jquery", "underscore", "backbone", "views/panel/member"], function ($, _, Backbone, UserView) {
    "use strict";
    
    var MembersView = Backbone.View.extend({
    
        el: $('#members-list'),
   
   
        fired: false,

        
        initialize: function () { 
            var self = this;
            
            self.collection.fetch({
                cache: true,
                
                expires: (1000 * 60) * 60,
                
                prefillSuccess: function (collection, response, options) {
                    self.render();
                    
                    // search view waiting for this event to populate auto-fill
                    if (collection.length > 0) {
                        self.collection.trigger('complete');
                    }
                },
                
                success: function (collection, response, options) {
                        self.render();
                    
                        // search view waiting for this event to populate auto-fill
                        self.collection.trigger('complete');
                }
            });
            
            return self;
        },

        
        render: function () {
            var self = this, itemlist, fragment = document.createDocumentFragment(), userView, model;

            itemlist = self.randomArray(12, self.collection.length - 1);
            
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
            var temp = [], tracker = {};
            
            while(temp.length < size) {
                var num = Math.floor((Math.random() * collectionLength) + 1);
                
                
                if (!tracker.hasOwnProperty(num)) {
                    temp.push(num);
                    tracker[num] = true;
                }                
            }
            
            return temp;
        }       
    });
    
    return MembersView;
});
