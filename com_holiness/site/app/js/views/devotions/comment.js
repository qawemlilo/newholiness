
define([
    "jquery",
    "underscore", 
    "backbone",
    "text!tmpl/comment.html",    
    "moment"
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
    
    var CommentView = Backbone.View.extend({

        className: 'comment row-fluid',

        template: _.template(Template),
        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.name = $.toUpperFirst(data.name);
            data.ts = this.getTime(data.ts);
            
            template = this.template(data);
 
            this.$el.append(template);
            
            return this;
        },

        getTime: function (ts) {
            var ago = moment(ts, "YYYY-MM-DD HH:mm:ss").fromNow();
            
            return ago;
        }        
    });
    
    return CommentView;
});
