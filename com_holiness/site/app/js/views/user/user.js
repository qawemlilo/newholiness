
define([
    "jquery",
    "underscore", 
    "backbone", 
    "collections/partners",    
    "views/user/devotions", 
    "views/user/partners",
    "views/user/pagination",
    "text!tmpl/profile.html"
], function ($, _, Backbone, PartnersCollection, DevotionsView, PartnersView, PaginationView, Template) {
    "use strict";
    
    var UserView = Backbone.View.extend({
    
        el: '#user-content',
        
        
        events: {
            'click ul.nav-tabs li a': 'loadTabs',
            'click button.makedevotionpartner': 'addPartner'
        },
        
        
        template: _.template(Template),
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;
                
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
            
            if (self.collection && self.collection.length > 0 && self.collection.get(id)) {
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
            var partners = _.pluck(this.user.partners, 'id');
            
            data.value = $.toUpperFirst(data.value);
            data.mine = (this.user.id === data.id);
            data.mypartner = ($.inArray(data.id, partners) > -1); 

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
            if (opentab === 'showdevotions') {
                this.trigger('showdevotions', this.model.get('memberid'));
            }
            
            if (opentab === 'showpartners') {
                this.trigger('showpartners', this.model.get('id'));
            }


            return false;
        },
        
        
        addPartner: function (event) {
            event.preventDefault();
            
            var self = this;
            
            self.model.addPartner(function(err, data){
                if (!err) {
                    $('button.makedevotionpartner').off().fadeOut().remove();
                }
            });

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
