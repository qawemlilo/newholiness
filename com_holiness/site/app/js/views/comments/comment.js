
define([
    "jquery",
    "underscore", 
    "backbone",
    "text!tmpl/comments/comment.html",
    "text!tmpl/comments/edit.html",   
    "moment",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, Template, editTemplate) {
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
            'click a.amen-plus': 'plusOneAmen',
            
            "click .comment-item-edit": "editItem",
            "click .comment-item-delete": "deleteItem",
            "submit .comment-edit form": "saveEdit",
            "click .comment-edit form .cancel": "closeEdit",
            "keypress .comment-edit form textarea": "submitOnEnter"
        },
         

        template: _.template(Template),
        
        
        editTemplate: _.template(editTemplate),
        
        
        render: function () {
            var data = this.model.toJSON();
            
            data.name = $.toUpperFirst(data.name);
            data.ts = this.getMyTime(data.ts);
            data.amens = (data.amens) ? data.amens.split(',').length : false;
            data.mine = (HolinessPageVars.id === data.userid);
 
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
        
        
        
        closeEdit: function (event) {
            if (event) {
                event.preventDefault();
            }
            
            var self =  this;
            
            self.$el.fadeOut(function () {
                self.render();
                self.$el.fadeIn();
            });
        },
        
        
        
        editItem: function (event) {
            event.preventDefault();

            if (HolinessPageVars.id !== this.model.get('userid')) {
                return false;
            }
            
            var self =  this, 
                template,
                uId = (new Date().getTime()),
                charsId = 'chars' + uId,
                textId = 'text' + uId;
                
            template = self.editTemplate({comment: self.model.get('comment'), charsId: charsId, textId: textId});
            
            self.$('.comment-main').fadeOut(function () {
                self.$('.comment-edit').html(template).fadeIn();
                
                self.$('.comment-edit textarea').wordLimit({counterDiv: '#' + charsId});
            });
            

        },
        
        
        
        saveEdit: function (event) {
            event.preventDefault();
            
            if (HolinessPageVars.id !== this.model.get('userid')) {
                return false;
            }
            
            var form = $(event.currentTarget).serializeArray(), formObj = {};
            
            _.each(form, function (fieldObj) {
                formObj[fieldObj.name] = fieldObj.value;
            });

            this.model.save({'comment': formObj.txt}, {
                success: function (model, data) {
                    noty({text: 'Comment successfully updated!', type: 'success'});
                },
                error: function (model, data) {
                    noty({text: 'Error. Comment not updated.', type: 'error'});
                }
            });
            
            this.closeEdit();
        },      
        
        
        
        submitOnEnter: function (event) {
            if (event.which === 13) {
                event.preventDefault();
                this.$('.comment-edit form').submit();
            }
        },
        
        
        
        deleteItem: function (event) {
            event.preventDefault();
            
            if (HolinessPageVars.id !== this.model.get('userid')) {
                return false;
            }
            
            this.$el.addClass('highlight')
            
            .fadeOut(function () {
                this.$el.off();
                this.model.destroy({
                    success: function(model, response) {
                        noty({text: 'Comment successfully deleted!', type: 'success'});
                    },
                    error: function (model, data) {
                        noty({text: 'Error. Comment not deleted.', type: 'error'});
                    }
                });
                
            }.bind(this));
        },
        

        plusOneAmen: function (event) {
            event.preventDefault();
            
            var self = this, strarr, amens = self.model.get('amens');
            
            if (amens) {
                strarr = amens.toString().split(',');
                strarr.push(HolinessPageVars.id + '');
                amens = strarr;
            }
            else {
                amens = [HolinessPageVars.id + ''];   
            }

            amens = amens.join(',');
            self.model.set({'amens': amens});
            
            self.model.saveAmen(function (error, data) {
                if (error) {
                    noty({text: 'Amen not saved!', type: 'error'}); 
                }
                else {
                    noty({text: 'Amen saved!', type: 'success'});
                }
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
