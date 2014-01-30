    
define(["jquery"], function($) {
    "use strict";
    
    var handleForm = function (event, opts) {
        var self = opts.form,
            progress = $('form .' + opts.progress),
            response = $('form .' + opts.response);
            
        progress.slideDown(function () {
            $.post(opts.action, $(self).serialize() + '&t=' + (new Date().getTime()) , 'text')
            
            .done(function(res) {
                if (typeof res === 'object') {
                    res = res.message;
                }
                
                progress.slideUp(function () {
                    response.addClass('alert-success').html($('<strong>' + res + '</strong>')).slideDown('slow');
                });
                  
                window.setTimeout(function () { 
                    response.slideUp(function () {
                        response.removeClass('alert-success');
                    }); 
                }, 10 * 1000);
            })
            
            .fail(function(res) {
                if (typeof res === 'object') {
                    res = res.message;
                }
                
                progress.slideUp(function () {
                    response.addClass('alert-error').html($('<strong>' + res + '</strong>')).slideDown('slow');
                });
                  
                window.setTimeout(function () { 
                    response.slideUp(function () {
                        response.removeClass('alert-error');
                    }); 
                }, 10 * 1000);
            });
        });
            
        return false;
    },
    
    email = function () {
        $('#myModal').modal({
            keyboard: false,
            show: false
        });
        
        
        $('#chgform').on('submit', function (event) {
            return handleForm(event, {
                form: this,
                progress: 'passprogress',
                response: 'passresponse',
                action: $(this).attr('action')
            });
        });
    };
    
    return email;
});
