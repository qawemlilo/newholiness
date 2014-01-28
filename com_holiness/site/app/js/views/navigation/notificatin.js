
define(["jquery", "underscore", "backbone", "text!tmpl/request.html"], function ($, _, Backbone, Template) {
    "use strict";
    
    var Notification = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(Template),
        
        
        events: {
            'click #acceptrequest': 'respond',
            'click #ignorerequest': 'respond'
        },


        
        render: function () {
            var template, data = this.model.toJSON();

            template = this.template(data);
            this.$el.append(template);
            this.$el.append($('<hr>'));
            
            return this;
        },
        
        
        respond: function (event) {
            event.preventDefault();
            
            var elemId = $(event.currentTarget).attr('id'),
                partnerid = this.model.get('userid'), 
                id = this.model.get('id'),
                self = this,
                response = {acceptrequest: 'accept', ignorerequest: 'ignore'};
            
            $("#requestnotices").find("span.noti-indicator").empty().hide();
            
            self.model.respond(response[elemId], id, partnerid, function (error, data) {
                self.$el.off()
                .fadeOut('slow', function () {
                    self.$el.remove();
                });                    
            });        
        }
    });
    
    return Notification;
});
