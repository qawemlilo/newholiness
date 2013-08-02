
jQuery.noConflict();


(function ($) {

    $.toUpperFirst = function(txt) {
        var txtArr = txt.toLowerCase().split(" "),
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
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    }),
    
    
    Partner = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    }),
    
    
    UsersCollection = Backbone.Collection.extend({
        model: User      
    }),
    
    
    PartnersCollection = Backbone.Collection.extend({
        model: Partner      
    }),
    
    
    Devotion = Backbone.Model.extend({
        defaults: {
            id: 0, 
            theme: ""
        }
    }),
    
    
    DevotionsCollection = Backbone.Collection.extend({
        model: Devotion,
        url: 'index.php?option=com_holiness&task=devotion.getdevotions'
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
        
        
        events: {
            'click ul.nav-tabs li a': 'renderDevotions'
        },
        
        
        userid: 0,
        
        
        template: _.template($("#user-tpl").text()),
        
        
        render: function (id) {
            var template, model, self = this, modelJSON;
            
            if (self.collection && this.collection.length > 0) {
                model = self.collection.get(id);
                
                modelJSON = model.toJSON();
                
                modelJSON.value = $.toUpperFirst(modelJSON.value);
                
                template = self.template(modelJSON);
                self.$el.html(template);
                self.$el.removeClass('hide');
                self.trigger('showdevotions', modelJSON.memberid);
                self.userid = modelJSON.memberid;
            }
            else {
                self.collection.on('render', function () {
                    model = self.collection.get(id);
                    modelJSON = model.toJSON();
                    
                    modelJSON.value = $.toUpperFirst(modelJSON.value);
                     
                    template = self.template(modelJSON);
                    self.$el.html(template);
                    self.$el.removeClass('hide');
                    
                    self.collection.off('render');
                    self.trigger('showdevotions', modelJSON.memberid);
                    self.userid = modelJSON.memberid;
                });
            }
            
            return self;
        },
        
        
        renderDevotions: function (event) {
            var nav = $(event.currentTarget), hash = nav.attr('href'), id = hash.substr(1);
            
            nav.tab('show');
            
            this.trigger(id, this.userid);

            return false;
        }       
    }),
    
    
    
    PartnerView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template($('#partners-tpl').text()),

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

            template = this.template(data);
 
            this.$el.append(template);
            
            this.model.set({viewed: true});
            
            return this;
        }       
    }),
    
    
    
    PartnersView = Backbone.View.extend({
    
        el: 'ul',
        
        
        className: 'unstyled',

        
        initialize: function (options) {
            this.parent = options.parent;
            this.collection = options.collection;
            
            this.listenTo(this.parent, 'showpartners', this.fetchPartners);
        },

        
        render: function (error) {
            var fragment = document.createDocumentFragment(), pView;

            if (error) {
                $('#showpartners').html('<div style="margin-left:10px">Devotions partners not found.</div>');
                
                return;
            }
            
            this.collection.forEach(function (model) { 
                pView = new PartnerView({
                    model: model
                });
                
                fragment.appendChild(pView.render().el);
            });
            
            this.$el.html(fragment);
            $('#showpartners').html(this.$el);
            
            return this;
        },


        fetchPartners: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=user.getpartners&id=' + id;
            self.collection.fetch({
                cache: true, 
                expires: false,
                prefill: true,
            
                prefillSuccess: function () {
                    self.render(false); 
                },
                success: function () {
                    self.render(false);                    
                },
                error: function () {
                    self.render(true);
                }
            });        
        }          
    }),
    
    
    DevotionView = Backbone.View.extend({

        tagName: 'li',

        template: _.template('<a href="index.php?option=com_holiness&view=devotion&id=<%= id %>"><i class="icon-file"></i> <%= theme %></a>'),
        
        render: function () {
            var data = this.model.toJSON(),
                template;

            template = this.template(data);
 
            this.$el.append(template);
            
            return this;
        }       
    }),
    
    
    DevotionsView = Backbone.View.extend({
    
        tagName: 'ul',
        
        
        className: 'unstyled',
        
        
        initialize: function (options) {
            this.parent = options.parent;
            this.collection = options.collection;
            
            this.listenTo(this.parent, 'showdevotions', this.fetchDevotions);
        },
        
        
        render: function (error) {
            var fragment = document.createDocumentFragment(), view;
            
            if (error) {
                $('#showdevotions').html('<div style="margin-left:10px">Devotions not found.</div>');
                
                return;
            }
            
            this.collection.forEach(function (model) {
                view = new DevotionView({
                    model: model
                });
                
                fragment.appendChild(view.render().el);
            });
            
            this.$el.html(fragment);
            
            $('#showdevotions').html(this.$el);
  
            return this;
        },

        fetchDevotions: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=devotion.getdevotions&id=' + id;
            self.collection.fetch({
                cache: true, 
                expires: false,
                prefill: true,
            
                prefillSuccess: function () {
                    self.render(false); 
                },
                success: function () {
                    self.render(false);                    
                },
                error: function () {
                    self.render(true);
                }
            });        
        }        
    });
    
    
    
    
    
    
    $.initApp = function (getusersUrl) {
        var users = new UsersCollection(), 
            devotions = new DevotionsCollection(),
            //partners = new PartnersCollection(),
            userLayout,
            homeLayout,
            devotionsLayout,
            partnersLayout;
        
        users.url = getusersUrl;
        
        users.fetch({
            cache: true, 
            expires: false,
            prefill: true,
            
            prefillSuccess: function () {
                users.trigger('render');               
            },
            success: function () {
                users.trigger('render'); 
            }            
        });
        
        userLayout = new UserView({
            collection: users
        });
       
        devotionsLayout  = new DevotionsView({
            parent: userLayout,
            collection: devotions
        });
        /*
        partnersLayout  = new PartnersView({
            parent: userLayout,
            collection: partners
        });*/
        
        homeLayout = new HomeView();
        
        
        App.views.user = userLayout;
        App.views.userDevotions = devotionsLayout;
        App.views.home = homeLayout;
        //App.views.partners = partnersLayout;
        
        
        $(".alert").alert();
        new Router(App);
        Backbone.history.start();
        
        return App;
    };    
}(jQuery));
