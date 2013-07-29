
jQuery.noConflict();

(function ($) {
    var memberHtml = '<div class="row-fluid fellow">';
    memberHtml += '<div class="span3"><a href="#/users/<%= id %>"><img src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" class="img-polaroid" onerror="this.src=\'data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\'" /></a></div>';
    memberHtml += '<div class="span9"><div class="row-fluid"><strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>';
    memberHtml += '<small><%= church %></small><br>';
    memberHtml += '<button class="btn btn-primary add-partner"><i class="icon-group"> Make devotion partner</button></div></div>';
    
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "",          
            imgext: "", 
            value: ""
        }
    });
    
    
    var UsersCollection = Backbone.Collection.extend({
        model: User,

        url: 'index.php?option=com_holiness&task=user.getusers',
        
        ogModels: false,

        getUsers: function (num) {
            var currentmodels = [], i;
            
            if (this.ogModels) this.models = this.ogModels;
            
            for (i = 0; i < num; i++) {
               var model = this.pop();
               currentmodels.push(model);
            }
            
            this.ogModels = this.clone().models;
            
            this.reset(currentmodels);
        }        
    });


    var UserView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(memberHtml),

        
        render: function () {
            var template, data = this.model.toJSON();

            template = this.template(data);
 
            this.$el.append(template);
            
            this.model.set({viewed: true});
            
            return this;
        }       
    });
    
    

    
    
    
    var UsersView = Backbone.View.extend({
    
        el: $('#members-list'),

        
        initialize: function () { 
            var self = this;
            
            self.listenTo(self.collection, 'reset', self.render);
            
            self.collection.fetch({
                success: function (collection, response, options) {
                    self.collection.getUsers(5);
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
    
    
    $.getUsers = function () {
        var members = new UsersCollection();
        
        var membersView = new UsersView({
            collection: members
        });
        
        return membersView;
    };    
}(jQuery))
