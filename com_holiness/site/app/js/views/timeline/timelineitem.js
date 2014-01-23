
define([
    "jquery",
    "underscore", 
    "backbone", 
    "text!tmpl/timeline/timelineitem.html",
    "text!tmpl/timeline/edittimeline.html",
    "moment",
    "wordlimit",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, Template, editTemplate) {
    "use strict";
    
    var TimelineItemView =  Backbone.View.extend({
    
        className: 'timeline-item',
        
        
        labelColor: {
            'prayerrequest': 'important',
            
            'prophecy': 'inverse',
            
            'revelation': 'info',
            
            'testimony': 'success'
        },
        
        
        events: {
            "click .edit-timeline-item-edit": "editItem",
            "click .edit-timeline-item-delete": "deleteItem",
            "submit .timelinepost-main-edit form": "saveEdit",
            "click .timelinepost-main-edit form .cancel": "closeEdit"
        },
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;
        },
        
        
        postLabel: {
            'prayerrequest': 'Prayer Request',
            'prophecy': 'Prophecy',
            'revelation': 'Revelation',
            'testimony': 'Testimony'
        },
        
    
        template: _.template(Template),
        
        
        editTemplate: _.template(editTemplate),
        
        
        render: function () {
            var data = this.model.toJSON();
                
            if (!data.id) {
                data.id = 0; 
            }
            
            if (this.user && this.user.get('id')) {
                data.mine = (this.user.get('id') === data.userid);
            }
            else {
                data.mine = true;    
            }
            
            data.ts = this.timeAgo(data.ts);
            data.label = this.labelColor[data.posttype];
            data.posttype = this.postLabel[data.posttype];
            
            this.$el.append(this.template(data));

            return this;                
        },
        
        
        timeAgo: function (ts) {
            var ago;
            
            if (ts) {
                ago = moment.unix(parseInt(ts, 10)).fromNow();
            }
            else {
                ago = moment(new Date().getTime()).fromNow();
            }
            
            return ago;     
        },
        
        
        
        closeEdit: function (event) {
            if (event) {
                event.preventDefault();
            }
            
            this.$el.fadeOut(function () {
                this.$el.empty();
                this.render();
                this.$el.fadeIn();
            }.bind(this));
        },
        
        
        
        editItem: function (event) {
            event.preventDefault();
            
            var userid = this.user.get('id');

            if (userid && userid !== this.model.get('userid')) {
                return false;
            }
            
            var self =  this, 
                template,
                uId = (new Date().getTime()),
                charsId = 'chars' + uId,
                textId = 'text' + uId;
                
            template = self.editTemplate({post: self.model.get('post'), charsId: charsId, textId: textId});
            
            self.$('.timelinepost-main').fadeOut(function () {
                self.$('.timelinepost-main-edit').html(template).fadeIn();
                
                self.$('.timelinepost-main-edit textarea').wordLimit({counterDiv: '#' + charsId});
            });
            

        },
        
        
        
        saveEdit: function (event) {
            event.preventDefault();
            
            var userid = this.user.get('id');
            
            if (userid && userid !== this.model.get('userid')) {
                return false;
            }
            
            var form = $(event.currentTarget).serializeArray(), formObj = {};
            
            _.each(form, function (fieldObj) {
                formObj[fieldObj.name] = fieldObj.value;
            }); 
              
            this.model.save({'post': formObj.post}, {
                success: function(model, data) {
                    noty({text: 'Post successfully updated!', type: 'success'});
                },
                error: function (model, data) {
                    noty({text: 'Error. Post not updated', type: 'error'});
                }
            });
            
            
            
            this.closeEdit();
        },
        
        
        
        deleteItem: function (event) {
            event.preventDefault();
            
            var userid = this.user.get('id');
            
            if (userid && userid !== this.model.get('userid')) {
                return false;
            }
            
            this.$el.addClass('highlight')
            
            .fadeOut(function () {
                this.$el.off();
                this.model.destroy({
                    success: function(model, response) {
                        noty({text: 'Post successfully deleted!', type: 'success'});
                    },
                    error: function (model, data) {
                        noty({text: 'Error. Post not deleted', type: 'error'});
                    }
                });
                
            }.bind(this));
        },
        
        
        
        serializeForm: function (id) {
            var formValues = this.$(id).serializeArray(), obj = {}, cleantags = [];
            
            _.each(formValues, function (fieldObj) {
                if (fieldObj.name !== 'submit') {
                    obj[fieldObj.name] = fieldObj.value;
                }
            });
            
            if (!obj.tags) {
                obj.tags = ['uncategorised'];
            }
            else {
                obj.tags = obj.tags.split(',') || [obj.tags];
                obj.publik = !(!!obj.publik);
            
                _.each(obj.tags, function (rawTag) {
                    cleantags.push(rawTag.trim());
                });
             
                obj.tags = cleantags;
            }
            
            return obj;
        },
    });
    
    return TimelineItemView;
});
