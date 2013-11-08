    
require(["jquery", "underscore", "backbone"], function($, _, Backbone) {
    var DevotionView = Backbone.View.extend({

        tagName: 'li',


        template: _.template('<a href="index.php?option=com_holiness&view=devotion&id=<%= id %>"><i class="icon-file"></i> <%= theme %></a>'),
        
        
        render: function () {
            var data = this.model.toJSON(),
                template;

            template = this.template(data);
 
            this.$el.append(template);
            
            return this;
        }       
    });
    
    return DevotionView;
});
