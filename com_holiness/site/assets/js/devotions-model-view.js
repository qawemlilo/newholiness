    var Devotion = Backbone.Model.extend({
        defaults: {
            id: 0, 
            theme: ""
        }
    }),
    
    
    DevotionsCollection = Backbone.Collection.extend({
        model: Devotion,
        url: 'index.php?option=com_holiness&task=devotion.getdevotions'
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
            
            this.$el.empty();
            
            if (error) {
                this.$el.parent.html('<div style="margin-left:10px">Devotions not found.</div>');
                $(".alert").alert();
                
                return;
            }
            
            this.collection.forEach(function (model) {
                view = new DevotionView({
                    model: model
                });
                
                fragment.appendChild(view.render().el);
            });
            
            this.$el.append(fragment);
  
            return this;
        },

        
        fetchDevotions: function (id) {
            var self = this;
            
            self.collection.url = 'index.php?option=com_holiness&task=devotion.getdevotions&id=' + id;
            
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