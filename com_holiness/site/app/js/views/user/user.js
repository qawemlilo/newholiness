
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/users",
    "collections/partners",    
    "views/user/devotions", 
    "views/user/partners",
    "views/user/pagination",
    "text!tmpl/profile.html"
], function ($, _, Backbone, Users, PartnersCollection, DevotionsView, PartnersView, PaginationView, Template) {
    "use strict";
    
    var UserView = Backbone.View.extend({
    
        el: '#user-content',
        
        
        events: {
            'click ul.nav-tabs li a': 'loadTabs'
        },
        
        
        template: _.template(Template),
        
        
        initialize: function () {
            var self = this;
            
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
                self.waiting = true;
                
                self.collection.on('render', function () {
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
            
            // the partners and devotions views are listening for these actions
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
