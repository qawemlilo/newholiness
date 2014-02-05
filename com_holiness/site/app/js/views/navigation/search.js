    
define(["jquery", "underscore", "backbone", "text!tmpl/member-search.html", "typeahead"], function($, _, Backbone, Template) {
    "use strict";
    
    var Search = Backbone.View.extend({

        el: '#search',
        
        
        initialize: function (opts) {
            var self = this;
            
            self.user = opts.user;

            self.activateSearch(self.collection.toJSON());
        },


        activateSearch: function (suggestions) {
            var self = this;
            
            self.$el.typeahead('destroy');
            self.$el.typeahead({
              
                name: 'search',
                
                local: suggestions,
              
                template: Template,
            
                engine: {
                    compile: function(template) {
                        var compiled = _.template(template);
                    
                        return {
                            render: function(context) { 
                                return compiled(context);
                            }
                        };
                    }
                },
            
                limit: 10
            });
            
            self.$el.on('typeahead:selected', function (event, user) {
                window.location.href = (self.user.get('baseUrl')) + '#/users/' + user.id;
            });     
        }        
    });
    
    return Search;
});
