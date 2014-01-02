
define(["jquery", "underscore", "backbone", "text!tmpl/request.html"], function ($, _, Backbone, Template) {
    "use strict";
    
    var RequestView = Backbone.View.extend({
    
        tagName: 'li',


        template: _.template(Template),
        
        
        events: {
            'click #acceptrequest': 'acceptRequest',
            'click #ignorerequest': 'ignoreRequest'
        },


        
        render: function () {
            var template, data = this.model.toJSON();

            template = this.template(data);
            this.$el.append(template);
            this.$el.append($('<hr>'));
            
            return this;
        },
        
        
        acceptRequest: function (event) {
            event.preventDefault();
            
            var currentElem = $(event.currentTarget),
                partnerid = this.model.get('userid'), 
                id = this.model.get('id'),
                self = this;
            
            $("#requestnotices").find("span.noti-indicator").empty().hide();
            self.model.respond('accept', id, partnerid, function (error, data) {
                self.$el.off().remove();              
            });        
        },



        ignoreRequest: function (event) {
            event.preventDefault();
            
            var currentElem = $(event.currentTarget),
                partnerid = this.model.get('userid'),
                id = this.model.get('id'),
                self = this;
            
            $("#requestnotices").find("span.noti-indicator").empty().hide();
            self.model.respond('ignore', id, partnerid, function (error, data) {
                self.$el.off().remove();              
            }); 
                  
        }
    });
    
    return RequestView;
});
