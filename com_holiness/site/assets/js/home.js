
jQuery.noConflict();


(function ($) {

    $.toUpperFirst = function(txt) {
        var txtArr = txt.split(" "),
        words = [];
	    
        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1))  
        });
        
        return words.join(" ");
    };
    
    
    
    var App = {
        models: {},
        views: {},
        collections: {}
    };
    
    
    var Router = Backbone.Router.extend({
    
        routes: {
            
            '': 'home',
            
            'users/:id': 'loadUser'
        },
        
        initialize: function (app) { 
            this.app = app
        },
        
        
        home: function () {
            $('.content-display:not(.hide)').addClass('hide');
            this.app.views.home.render();
        },
        
        
        loadUser: function (id) {
            $('.content-display:not(.hide)').addClass('hide');
            this.app.views.user.render(id);
        }
    });
    
    
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            userid: 0, 
            imgext: "", 
            imgext: "", 
            value: ""
        }
    }),
    
    
    UsersCollection = Backbone.Collection.extend({
        model: User      
    }), 


    HomeView = Backbone.View.extend({

        el: '#timeline',

        
        render: function () {
            this.$el.removeClass('hide');
            
            return this;
        }       
    }),
    
    
    UserView = Backbone.View.extend({
    
        el: '#user-content',
        
        template: _.template($("#user-tpl").text()),
        
        render: function (id) {
            var template, model, self = this;
            
            if (self.collection && this.collection.length > 0) {
                model = self.collection.get(id);
                template = self.template(model.toJSON());
                self.$el.html(template);
                self.$el.removeClass('hide');
            }
            else {
                self.collection.on('render', function () {
                    model = self.collection.get(id);
                    template = self.template(model.toJSON());
                    self.$el.html(template);
                    self.$el.removeClass('hide');
                    
                    self.collection.off('render');
                });
            }
            
            return self;
        }        
    });
    
    
    
    
    
    
    $.initApp = function (collectionUrl) {
        var users = new UsersCollection(), router;
        
        users.url = collectionUrl;
        users.fetch({
            cache: true, 
            expires: (1000 * 60) * 60,
            prefill: true,
            
            prefillSuccess: function () {
                users.trigger('render');
                console.log('prefillSuccess')                
            },
            success: function () {
                users.trigger('render'); 
                console.log('Success'); 
            }            
        });
        
        App.views.user = new UserView({
            collection: users
        });
        
        App.views.home = new HomeView();
        
        router = new Router(App);
        
        Backbone.history.start();
        
        return App;
    };    
}(jQuery));
