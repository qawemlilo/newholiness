
define([
    "jquery", 
    "underscore", 
    "backbone", 
    "text!tmpl/member-side.html",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, Template) {
    "use strict";
    
    $.toUpperFirst = $.toUpperFirst || function(txt) {
        var txtArr = txt.toLowerCase().split(" "),
        words = [];

        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1));  
        });
        
        return words.join(" ");
    };
    
    var MemberView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(Template),
        
        
        events: {
            "click a.makedevotionpartner": "addPartner"
        },

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

            template = this.template(data);
 
            this.$el.append(template);
            
            this.model.set({viewed: true});
            
            return this;
        },
        
        
        addPartner: function (event) {
            event.preventDefault();
            
            var self = this;
            
            self.model.addPartner(function(err, data){
                if (!err) {
                    self.$el.off()
                    .addClass('highlight')
                    .fadeOut(function () {
                        self.$el.remove();
                    });
                    
                    noty({text: 'Request Sent!', type: 'success'});
                }
                else {
                    noty({text: "There's a bending Request", type: 'error'});
                }
            });
            return false;
        }
    });
    
    return MemberView;
});
