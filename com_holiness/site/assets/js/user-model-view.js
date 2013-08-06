    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    }),

    
    UsersCollection = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    }),
    
    
    UserView = Backbone.View.extend({
    
        el: '#user-content',
        
        
        events: {
            'click ul.nav-tabs li a': 'loadTabs'
        },
        
        
        waiting: false,
        
        
        template: _.template($("#user-tpl").text()),
        
        
        initialize: function () {
            var self = this;
            
            this.collection = new UsersCollection();
            
            this.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 7,
                
                prefill: true,
            
                prefillSuccess: function () {
                    if (self.waiting) {
                        self.collection.trigger('render');
                    }
                },
                success: function () {
                    if (self.waiting) {
                        self.collection.trigger('render');
                    }                        
                }            
            });
        },
        
        
        render: function (id) {
            var self = this;

            this.$el.empty();
            
            this.devotionsView = new DevotionsView({
                collection: new DevotionsCollection(),
                parent: self
            });
            
            this.partnersView = new PartnersView({
                collection: new PartnersCollection(),
                parent: self
            });
            
            if (this.collection && this.collection.length > 0) {
                this.showView(id);
            }
            else {
                this.waiting = true;
                
                this.collection.on('render', function () {
                    self.showView(id);
                    self.collection.off('render');
                    self.waiting = false;
                });
            }
            
            return self;
        },
        
        
        showView: function (id) {
            this.model = this.collection.get(id);
                
            var data = this.model.toJSON();
            data.value = $.toUpperFirst(data.value);
 
            this.$el.html(this.template(data));
            this.$el.removeClass('hide');
                
            this.trigger('showdevotions', data.memberid);        
        },
        
        
        loadTabs: function (event) {
            var nav = $(event.currentTarget), 
                hash = nav.attr('href'), 
                opentab = hash.substr(1);
            
            nav.tab('show');
            
            this.trigger(opentab, this.model.get('memberid'));

            return false;
        }      
    });
    
    
    $.initApp = function (getusersUrl) {
        var userLayout, homeLayout, router;
        
        userLayout = new UserView();
        
        homeLayout = new HomeView();
        
        
        App.views.user = userLayout;
        App.views.home = homeLayout;

        router = new Router(App);
        
        Backbone.history.start();
        
        return App;
    };