
define([
    "jquery",
    "underscore", 
    "backbone",
    "text!tmpl/partner.html",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, Template) {
    "use strict";
    
    var PartnerView = Backbone.View.extend({
    
        tagName: 'li',
        
        
        events: {
            'click ul.nav-tabs li a': 'loadTabs',
            'click button.add-partner': 'addPartner'
        },
        

        initialize: function (options) {
            this.user = options.user;
        },
        
        template: _.template(Template),

        
        render: function () {
            var template, data = this.model.toJSON();
            var partners = _.pluck(HolinessPageVars.partners, 'id');
            
            data.value = $.toUpperFirst(data.value);
            data.mypartner = ($.inArray(data.id, partners) > -1);
            data.mine = (parseInt(data.id, 10) === parseInt(HolinessPageVars.id, 10));

            template = this.template(data);
 
            this.$el.html(template);
            
            
            return this;
        },
        
        
        addPartner: function (event) {
            event.preventDefault();
            
            var self = this;
            
            self.model.addPartner(function(err, data){
                self.$('button.add-partner').off().addClass('btn-primary disabled');
                
                if (!err) {
                    noty({text: 'Your request has been sent!', type: 'success'});
                }
                else {
                    noty({text: 'You have already sent that user a request', type: 'error'});
                }
            });

            return false;
        }       
    });
    
    return PartnerView;
});
