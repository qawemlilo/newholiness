    
define(["jquery", "underscore", "backbone", "bootstrap"], function($, _, Backbone) {
    "use strict";
    
    var Nav = Backbone.View.extend({

        el: '#mainNavigation',
        
        
        activePopUp: false,
        
        
        events: {
            'click #acceptrequest': 'acceptRequest',
            'click #ignorerequest': 'ignoreRequest'
        },
        
        
        initialize: function () {
            var self = this;
            
            self.collection.on('complete', function () {
                self.fetchRequests();
            });
        },



        acceptRequest: function (event) {
            event.preventDefault();
            
            var currentElem = $(event.currentTarget);
            var res = currentElem.attr('id'); 
            var id = currentElem.data('id');
            
            $("#requestnotices").find("span.noti-indicator").empty().hide();       
        },



        ignoreRequest: function (event) {
            event.preventDefault();
            
            var currentElem = $(event.currentTarget);
            var res = currentElem.attr('id'); 
            var id = currentElem.data('id');
            
            $("#requestnotices").find("span.noti-indicator").empty().hide();       
        },
        
        
        
        
        fetchRequests: function() {
            var collection = this.collection;
            
            $.get('index.php?option=com_holiness&task=home.getpartners')
            .done(function(requests) {
                    var html = '<ul class="unstyled inline">';
                    
                    if (requests.length > 0) {
                    
                    $("#requestnotices .noti-indicator").text(requests.length + '').show();
                    
                    _.each(requests, function (request) {
                        var user = collection.get(request.userid);
                        
                        html += '<li><img class="img-polaroid" src="media/com_holiness/images/user-' + user.get('id') + '-icon.' + user.get('imgext') + '" style="float:left; margin-right:5px;">';
                        html += user.get('value') + '<br>'; 
                        html += '<small>(Partner Request)</small> <br>';
                        html += '<button id="acceptrequest" data-id="' + user.get('id') + '" class="btn btn-primary">Accept</button> ';   
                        html += '<button id="ignorerequest" data-id="' + user.get('id') + '"  class="btn">Ignore</button></li>';  
                        html += '<hr>';
                    });
                    
                    }
                    
                    html += '</ul>';
                    
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
    
    return Nav;
});
