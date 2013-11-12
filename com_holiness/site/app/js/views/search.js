    
define(["jquery", "underscore", "backbone", "typeahead"], function($, _, Backbone) {
    var Search = Backbone.View.extend({

        el: '#search',
        
        
        initialize: function (opts) {
            this.$el.typeahead('destroy')
            .typeahead({
              
                name: 'search',
           
                prefetch: {
                    url: 'index.php?option=com_holiness&task=user.getusers',
                    ttl: (1000 * 60) * 60
                },
              
                template: $('#search-tpl').text(),
            
                engine: {
                    compile: function(template) {
                        var compiled = _.template(template);
                    
                        return {
                            render: function(context) { 
                                return compiled(context);
                            }
                        }
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
