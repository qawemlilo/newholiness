jQuery.noConflict();

(function ($, window) {
    var active = false;
    
    function wResize() {
        var winW = $(window).width(), 
            Body = $('body'),
            cont = $('#reg-cont');

        if ( winW < '1024') {
            if (cont.hasClass('offset2')) {
               cont.removeClass('offset2');
            }               
        }
        if ( winW >= '1024' ) {
            if (!cont.hasClass('offset2')) {
               cont.addClass('offset2');
            } 
        }         

    }
    
    
    function logIn() {
        var loginform = $('#login-form'), regform = $('#reg-form'), link = $('#reg-link');

        link.on('click', function () {
            if (active) {
               return;
            }
            
            loginform.css({'display': 'none'});
            regform.css({'display': 'block'});

            return false;            
        });
    }
    
    function showLoading(fn) {
        $('#register-loading').slideDown(fn);    
    }
    

    function showResult(message, success) {
        var cont = $('#register-loaded'), 
            klass = success ? 'alert-success' : 'alert-error';
        
        $('#register-loading').slideUp(function () {
            cont.addClass(klass).html(message).slideDown();
            
            setTimeout(function () {
                cont.slideUp(function () {
                    cont.removeClass(klass).empty();
                });
            }, 10 * 1000);
            
            active = false;
        });    
    }
    
    
    function register() {
        var loginform = $('#login-form'), regform = $('#reg-form'), link = $('#login-link');

        link.on('click', function () {
            if (active) {
               return;
            }
            regform.css({'display': 'none'});
            loginform.css({'display': 'block'});

            return false;            
        });

        regform.on('submit', function (event) {
            active = true;
            
            showLoading(function () {
                $.post('index.php', regform.serialize())
                .done(function (data) {
                    showResult(data.message, true); 
                    regform.trigger('reset');                    
                })
                .fail(function (xhr) {
                    var data = JSON.parse(xhr.responseText);
                    showResult(data.message, false);
                });
            });
            
            return false;
        });        
    }
    
    $(function() {
        wResize();
        register();
        logIn();

        $(window).resize(function() {
            wResize();
        });
    });
}(jQuery, window));