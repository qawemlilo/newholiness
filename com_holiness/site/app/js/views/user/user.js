
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
                
            self.collection.once('render', function (uid) {
                self.showView(uid);
                self.waiting = false;
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
                
                // scroll to top
                $('html, body').stop().animate({
                    'scrollTop': 0 // - 200px (nav-height)
                }, 200, 'swing');
            }
            else {
                self.waiting = true;
                
                self.collection.fetch({
                    cache: true, 
                    
                    expires: (1000 * 60) * 60 * 24 * 2,
                
                    success: function () {
                        if (self.waiting) {
                            self.collection.trigger('render', id);
                        }                        
                    }            
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
            event.preventDefault();
            
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
