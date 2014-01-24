    
define(["jquery", "underscore", "backbone", "views/navigation/request", "models/request", "bootstrap"], function($, _, Backbone, RequestView, RequestModel) {
    "use strict";
    
    var Requests = Backbone.View.extend({

        el: '#mainNavigation',
        
        
        activePopUp: false,
        
        
        initialize: function () {
            var self = this;
            
            self.collection.on('complete', function () {
                self.fetchRequests();
            });
        },
        
        
        
        
        fetchRequests: function() {
            var collection = this.collection;
            
            $.get('index.php?option=com_holiness&task=user.getpartnerrequests')
            .done(function(requests) {
                    var html = $('<ul class="unstyled inline">');
                    
                    if (requests.length > 0) {
                    
                    $("#requestnotices .noti-indicator").text(requests.length + '').show();
                    
                    _.each(requests, function (request) {
                        var user, model, view;
                        
                        user = collection.get(request.userid);
                        
                        model = new RequestModel({
                            id: request.id, 
                            imgext: user.get('imgext'),
                            userid: user.get('id'),
                            name: user.get('value')
                        });
                        
                        view = new RequestView({
                            model: new RequestModel({
                                id: request.id, 
                                imgext: user.get('imgext'),
                                userid: user.get('id'),
                                name: user.get('value')
                            })
                        });
                        
                        html.append(view.render().el);
                    });
                    
                    }
                    
                    $('#requestnotices').popover({
                        'trigger': 'click',
                        'html': true,
                        'content': html
                    });
            })
            .fail(function () {
            });    
        }
    });
    
    return Requests;
});
