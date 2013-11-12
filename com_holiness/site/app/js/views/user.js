
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/users",
    "collections/partners",    
    "views/devotions", 
    "views/partners",
    "views/pagination"
], function ($, _, Backbone, Users, PartnersCollection, DevotionsView, PartnersView, PaginationView) {
    var UserView = Backbone.View.extend({
    
        el: '#user-content',
        
        
        events: {
            'click ul.nav-tabs li a': 'loadTabs'
        },
        
        
        template: _.template($("#user-tpl").text()),
        
        
        initialize: function () {
            var self = this;
            
            //window.scrollTo(0, 0);

            //this.collection = new UsersCollection();
            
            this.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,

                success: function () {
                    if (self.waiting) {
                        self.collection.trigger('render');
                    }                        
                }            
            });
        },
        
        
        render: function (id) {
            var self = this;

            self.$el.empty();
            
            self.devotionsView = new DevotionsView({
                parent: self
            });
            
            self.partnersView = new PartnersView({
                collection: new PartnersCollection(),
                parent: self
            });

            self.paginationView = new PaginationView({parent: self.devotionsView });
            
            if (self.collection && self.collection.length > 0) {
                self.showView(id);
            }
            else {
                self.collection.fetch({
                    cache: true, 
                    
                    expires: (1000 * 60) * 60 * 24 * 2,
                
                    success: function () {
                        self.showView(id);                       
                    }            
                });
            }
            
            return self;
        },
        
        
        render: function (id) {
            var self = this;

            this.$el.empty();
            
            this.devotionsView = new DevotionsView({
                parent: self
            });
            
            this.partnersView = new PartnersView({
                collection: new PartnersCollection(),
                parent: self
            });

            this.paginationView = new PaginationView({parent: this.devotionsView });
            
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
            
            this.$('#showdevotions').empty().append(this.devotionsView.el); //.append(this.paginationView.el);
            this.$('#showpartners').empty().append(this.partnersView.el);
                
            this.trigger('showdevotions', data.memberid);        
        },
        
        
        loadTabs: function (event) {
            var nav = $(event.currentTarget), 
                hash = nav.attr('href'), 
                opentab = hash.substr(1);
            
            nav.tab('show');
            
            this.trigger(opentab, this.model.get('memberid'));


            return false;
        },
        
        
        nextPage: function (event) {
            this.paginationView.parent.collection.nextPage();
            return false;            
        },
        
        
        prevPage: function (event) {
            this.paginationView.parent.collection.prevPage();
            return false;            
        }        
    });
    
    return UserView;
});
