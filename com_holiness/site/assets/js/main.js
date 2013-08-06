
jQuery.noConflict();


(function ($) {

    $.toUpperFirst = $.toUpperFirst || function(txt) {
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
        collections: {},
        router: {}
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
    }),
    
    
    
    
    HomeView = Backbone.View.extend({

        el: '#timeline',

        
        render: function () {
            this.$el.removeClass('hide');
            
            return this;
        }       
    });
    
    
    
    
    
    

    /*
        Devotions Subview
    */
    var Devotion = Backbone.Model.extend({
        defaults: {
            id: 0, 
            theme: ""
        }
    }),
    
    
    DevotionsCollection = Backbone.Collection.extend({
        model: Devotion,

        
        url: 'index.php?option=com_holiness&task=devotion.getdevotions',

        
        perPage: 10,

        
        next: false,

        
        prev: false,
        
        
        currentPage: 0,
        
        
        pages: [],
        
        
        
        init: function () {
            if (!this.ogModels) {
                this.ogModels = this.clone().models;
            }
            
            var counter = 0, page = 0, self = this;
            
            _.each(this.ogModels, function (model) {
                
 
                if (counter >= self.perPage) {
                    ++page;
                    counter = 0;
                }
                
                if (!_.isArray(self.pages[page])) {
                    self.pages[page] = [];
                } 
                
                self.pages[page].push(model);
                
                counter++;
            });
            
            this.getPage();
        },

        
        
        getPage: function (num) {
           

            if (num && num < this.pages.length) {
                this.currentPage = num;
            }
            
            if (this.currentPage + 1 >= this.pages.length) {
                this.next = false;
            }else {
                this.next = true;
            }
            if (this.currentPage - 1 < 0) {
                this.prev = false;
            } else {
                this.prev = true;
            }
            
            this.reset(this.pages[this.currentPage]);    
        },
        
        
        nextPage: function () {
            if (this.currentPage + 1 >= this.pages.length) {
                return false;
            }

            this.currentPage += 1;

            this.getPage();            
        },
        
        
        prevPage: function () {
            if (this.currentPage + 1 < 0) {
                return false;
            }

            this.currentPage -= 1;

            this.getPage();          
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
            
            this.$el.html('<li><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></li>');
            
            this.listenTo(this.parent, 'showdevotions', this.fetchDevotions);
            
            return this;
        },
        
        
        render: function (error) {
            var fragment = document.createDocumentFragment(), view;
            
            if (error) {
                this.$el.parent().html('<div style="margin-left:10px">Devotions not found.</div>');
                
                return;
            }
            
            this.collection.init();
            
            this.collection.forEach(function (model) {
                view = new DevotionView({
                    model: model
                });
                
                fragment.appendChild(view.render().el);
            });
            
            this.$el.empty().append(fragment);
  
            return this;
        },

        
        fetchDevotions: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=devotion.getdevotions&id=' + id;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function () {
                    self.render(false);                    
                },
                
                error: function () {
                    self.render(true);
                }
            });        
        }        
    });
    
    
    
    
    
    /*
        Devotion Partners Subview
    */
    
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    }),
    
    
    
    PartnersCollection = Backbone.Collection.extend({
        model: User      
    }),
    
    
    
    PartnerView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template($('#partners-tpl').text()),

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

            template = this.template(data);
 
            this.$el.html(template);
            
            
            return this;
        }       
    }),
    
    
    
    PartnersView = Backbone.View.extend({
    
        tagName: 'ul',
        
        
        className: 'unstyled',

        
        initialize: function (options) {
            this.parent = options.parent;
            this.collection = options.collection;
            
            this.$el.html('<li><img src="components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></li>');
            
            this.listenTo(this.parent, 'showpartners', this.fetchPartners);
            
            return this;
        },

        
        render: function (error) {
            var fragment = document.createDocumentFragment(), pView;

            if (error) {
                this.$el.parent().html('<div style="margin-left:10px">Devotion partners not found.</div>');
                
                return;
            }
            
            this.collection.forEach(function (model) { 
                pView = new PartnerView({
                    model: model
                });
                
                fragment.appendChild(pView.render().el);
            });
            
            this.$el.empty().append(fragment);

            return this;
        },


        fetchPartners: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=user.getpartners&id=' + id;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function () {
                    self.render(false);                    
                },
                
                error: function () {
                    self.render(true);
                }
            });        
        }          
    }),
    
    
    
    PaginationView = Backbone.View.extend({
    
        el: '#devpager',

        template: _.template($('#pagination-tpl').text()),

        
        initialize: function (options) {
            this.parent = options.parent;

            this.listenTo(this.parent.collection, 'reset', this.render);
            
            return this;
        },
        
        
        render: function () {
            var template,
                prev = this.parent.collection.prev,
                next = this.parent.collection.next;
            
            console.log(prev);
            console.log(next);
            template = this.template({prev: prev, nxt: next});
            console.log(template);
            
            this.$el.empty().append(template);
            
            return this;
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

            this.$el.empty();
            
            this.devotionsView = new DevotionsView({
                collection: new DevotionsCollection(),
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
            
            this.$('#showdevotions').empty().append(this.devotionsView.el);
            this.$('#showpartners').empty().append(this.partnersView.el);
            this.$('#devpager').empty().append(this.paginationView.el);
                
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
    
    
    $.initApp = function () {
        var userLayout, homeLayout, router;
        
        userLayout = new UserView();
        homeLayout = new HomeView();

        App.views.user = userLayout;
        App.views.home = homeLayout;
        
        App.router = new Router(App);
        
        Backbone.history.start();
        
        return App;
    };
}(jQuery));
