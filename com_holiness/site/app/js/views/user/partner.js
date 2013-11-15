
define([
    "jquery",
    "underscore", 
    "backbone",
    "text!tmpl/partner.html"
], function ($, _, Backbone, Template) {
    "use strict";
    
    var PartnerView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(Template),

        
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
