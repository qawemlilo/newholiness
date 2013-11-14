    
define(["jquery", "underscore", "backbone", "text!tmpl/member-search.html", "typeahead"], function($, _, Backbone, Template) {
    "use strict";
    
    var Search = Backbone.View.extend({

        el: '#search',
        
        
        initialize: function (opts) {
            var self = this;
            
            self.collection.once('complete', function () {
                var suggestions = self.collection.toJSON();
                self.activateSearch(suggestions);
            });
        },


        activateSearch: function (suggestions) {
            var self = this;
            
            self.$el.typeahead('destroy')
            .typeahead({
              
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
            })
            
            .on('typeahead:selected', function (event, user) {
                window.location.hash = '#/users/' + user.id;
            });     
        }        
    });
    
    return Search;
});
