requirejs.config({
    baseUrl: 'components/com_holiness/app/js',
   
    paths: {
        jquery: 'libs/jquery',
        underscore: 'libs/underscore',
        backbone: 'libs/backbone',
        bootstrap: 'libs/bootstrap',
        typeahead: 'libs/typeahead.min',
        moment: 'libs/moment',
        text: 'libs/text',
        wordlimit: 'libs/wordlimit',
        noty: 'libs/noty/jquery.noty',
        notyPosition: 'libs/noty/layouts/topCenter',
        notyTheme: 'libs/noty/themes/default'
    },
    
    shim: {
        underscore: {
            exports: '_'
        },
        
        jquery: {
            exports: '$'
        },
        
        typeahead: {
            deps: ['jquery']
        },
        
        backbone: {
            deps: ['underscore','jquery'],
            exports: 'Backbone'
        },
        
        bootstrap: {
            deps: ['jquery']
        },
        
        wordlimit: {
            deps: ['jquery']
        },
        
        noty: {
            deps: ['jquery']
        },
        
        notyPosition: {
            deps: ['jquery', 'noty']
        },
        
        notyTheme: {
            deps: ['jquery', 'noty']
        }
    }
});

require(["jquery", "app", "noty","notyTheme","notyPosition"], function($, App) { 
    "use strict";
    
    $(function () {
        $.noty.defaults = {
            layout: 'topCenter',
            theme: 'defaultTheme',
            type: 'alert',
            text: '',
            dismissQueue: true, // If you want to use queue feature set this true
            template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
            animation: {
                open: {height: 'toggle'},
                close: {height: 'toggle'},
                easing: 'swing',
                speed: 500 // opening & closing animation speed
            },
            timeout: 5000, // delay for closing event. Set false for sticky notifications
            force: false, // adds notification to the beginning of queue when set to true
            modal: false,
            maxVisible: 5, // you can set max visible notification for dismissQueue true option
            closeWith: ['click'], // ['click', 'button', 'hover']
            callback: {
                onShow: function() {},
                afterShow: function() {},
                onClose: function() {},
                afterClose: function() {}
            },
            buttons: false // an array of buttons
        };
        
        
        /*
           a little trick here to detect page
        */
        var devotion = $('#devotionid'), devotionid; 
        
        if (devotion.length) {
            devotionid = devotion.val();
        }
        else {
            devotionid = false;
        }

        App.init(devotionid);
    });
});
