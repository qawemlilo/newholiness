
define([
    "jquery",
    "underscore", 
    "backbone"
], function ($, _, Backbone) {
    var PartnerView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template($('#partners-tpl').text()),

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

            template = this.template(data);
 
            this.$el.html(template);
            
            
            return this;
        }       
    });
    
    return PartnerView;
});
