    var Partner = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    }),
    
    
    PartnersCollection = Backbone.Collection.extend({
        model: Partner      
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
            
            this.listenTo(this.parent, 'showpartners', this.fetchPartners);
        },

        
        render: function (error) {
            var fragment = document.createDocumentFragment(), pView;
            
            this.$el.empty();

            if (error) {
                this.$el.parent.html('<div style="margin-left:10px">Devotion partners not found.</div>');
                $(".alert").alert();
                
                return;
            }
            
            this.collection.forEach(function (model) { 
                pView = new PartnerView({
                    model: model
                });
                
                fragment.appendChild(pView.render().el);
            });
            
            this.$el.append(fragment);

            return this;
        },


        fetchPartners: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=user.getpartners&id=' + id;
            
            self.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 7,
                
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