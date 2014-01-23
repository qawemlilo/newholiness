
define([
    "jquery",
    "underscore", 
    "backbone",
    "text!tmpl/comments/comment.html",    
    "moment",
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
    
    var CommentView = Backbone.View.extend({

        className: 'comment row-fluid',
        
        
        events: {
            'click a.amen-plus': 'plusOneAmen'
        },
         

        template: _.template(Template),
        
        
        render: function () {
            var data = this.model.toJSON();
            
            data.name = $.toUpperFirst(data.name);
            data.ts = this.getMyTime(data.ts);
            data.amens = (data.amens) ? data.amens.split(',').length : false;
 
            this.$el.html(this.template(data));
            
            return this;
        },
        

        getMyTime: function (ts) {
        
            var ago;
            
            if (ts) {
                ago = moment(ts, "YYYY-MM-DD HH:mm:ss").fromNow();
            }
            else {
                ago = 'a few seconds ago';
            }
            
            
            return ago;
        },
        

        plusOneAmen: function (event) {
            event.preventDefault();
            
            var data = {
                commentid: this.model.get('id')
            },
            
            self = this,
            
            amens = this.model.get('amens');
            
            if (amens) {
                var cleanstr = amens.toString(),
                    strarr = cleanstr.split(',');

                strarr.push(HolinessPageVars.id + '');
                
                amens = strarr;
            }
            else {
                amens = [HolinessPageVars.id + ''];   
            }

            amens = amens.join(',');
            
            this.model.set({'amens': amens});
            
            $.post('index.php?option=com_holiness&task=comments.addamen', data)
            .done(function(data){
                noty({text: 'Amen saved!', type: 'success'});  
            })
            .fail(function () {
                noty({text: 'Amen not saved!', type: 'error'});  
            }); 
            
            self.$el.fadeOut(function () {
                self.$el.empty();
                self.render();
                self.$el.fadeIn();
            });   
        }        
    });
    
    return CommentView;
});
