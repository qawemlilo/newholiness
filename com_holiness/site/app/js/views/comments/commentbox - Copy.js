
define([
    "jquery",
    "underscore", 
    "backbone",
    "views/devotions/comment",
    "models/comment",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, View, Model) {
    "use strict";

    var CommentBox =  Backbone.View.extend({
    
        el: '#devotioncommentbox',
        
        
        events: {
            'submit #submitcomment': 'submitComment'
        },      
        
        
        
        submitComment: function (event) {
        
            event.preventDefault();
            
            var data = this.formToObject();
            var model = new Model({
                ts: false, 
                imgext: HolinessPageVars.imgext, 
                userid: data.userid, 
                comment: data.txt, 
                name: data.name
            });

            var view = new View({model: model});
            
            $('#commentscontainer').append(view.render().el);
            
            this.send(data, function (error, res) {
                if(!error) {
                    noty({text: 'Comment saved!', type: 'success'});
                }
                else {
                    noty({text: 'Comment not saved!', type: 'error'});
                }
            });
            
           document.forms['submitcomment'].reset();
        },
        
    
        formToObject: function () {
            var formObj = {}, arr = this.$('#submitcomment').serializeArray();
        
            _.each(arr, function (fieldObj) {
                if (fieldObj.name !== 'submit') {
                    formObj[fieldObj.name] = fieldObj.value;
                }
            });
        
            return formObj;
        },
        
        
        send: function(data, fn) {
            $.post('index.php?option=com_holiness&task=comments.addcomment', data)
            .done(function(data){
                fn(false, data);
            })
            .fail(function () {
               fn(true);
            });    
        }
    });
    
    return CommentBox;
});
