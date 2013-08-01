
jQuery.noConflict();

(function ($) {
    $.toUpperFirst= function(txt) {
        var txtArr = txt.split(" "),
        words = [];
	    
        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1))  
        });
        
        return words.join(" ");
    };
    
    var memberHtml = '<div class="row-fluid fellow">';
    memberHtml += '<div class="span3"><img src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" onerror="this.src=\'modules/mod_hpmembers/assets/images/none.jpg\'" /></div>';
    memberHtml += '<div class="span9"><div class="row-fluid"><p><strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>';
    memberHtml += '<small><%= church %></small></p>';
    memberHtml += '<p><button class="btn add-partner"><small>Make devotion partner</small></button></p></div></div>';
    
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "",          
            imgext: "", 
            value: ""
        }
    });
    
    
    Backbone.Collection.prototype.getUsers = function (num) {

        if (!this.ogModels) {
            this.models = _.shuffle(this.models);
            this.ogModels = this.clone().models;
        }
            
        var currentmodels = this.ogModels.splice(0, num);
            
            
        this.reset(currentmodels);    
    }; 
    
    
    var UsersCollection = Backbone.Collection.extend({
        model: User,

        url: 'index.php?option=com_holiness&task=user.getusers'       
    });


    var UserView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(memberHtml),

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

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