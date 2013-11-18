
define(["jquery", "underscore", "backbone", "text!tmpl/member-side.html"], function ($, _, Backbone, Template) {
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

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.value = $.toUpperFirst(data.value);

            template = this.template(data);
 
            this.$el.append(template);
            
            this.model.set({viewed: true});
            
            return this;
        }       
    });
    
    return MemberView;
});