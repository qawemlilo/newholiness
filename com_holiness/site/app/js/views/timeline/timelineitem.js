
define([
    "jquery",
    "underscore", 
    "backbone", 
    "text!tmpl/timelineitem.html",
    "moment"
], function ($, _, Backbone, Template) {
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
            "click .edit-timeline-item-delete": "deleteItem"
        },
        
        
        initialize: function (opts) {
            var self = this;
            
            self.app = opts.app;
        },
        
        
        postLabel: {
            'prayerrequest': 'Prayer Request',
            'prophecy': 'Prophecy',
            'revelation': 'Revelation',
            'testimony': 'Testimony'
        },
        
    
        template: _.template(Template),
        
        
        render: function () {
            var data = this.model.toJSON(), template;
                
            if (!data.id) {
                data.id = 0; 
            }
            
            data.ts = this.timeAgo(data.ts);
            data.label = this.labelColor[data.posttype];
            data.posttype = this.postLabel[data.posttype];
            template = this.template(data);
            
            this.$el.append(template);

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
        
        
        
        editItem: function (event) {
            event.preventDefault();
            
            if (this.app.user.id !== this.model.get('userid')) {
                return false;
            }
        },
        
        
        
        deleteItem: function (event) {
            event.preventDefault();
            
            if (this.app.user.id !== this.model.get('userid')) {
                return;
            }
            
            this.$el.addClass('highlight')
            
            .fadeOut(function () {
                this.$el.off();
                this.model.destroy();
            }.bind(this));
        }
    });
    
    return TimelineItemView;
});
