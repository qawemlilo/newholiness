requirejs.config({
    baseUrl: 'components/com_holiness/app/js',
   
    paths: {
        jquery: 'libs/jquery',
        underscore: 'libs/underscore',
        backbone: 'libs/backbone',
        bootstrap: 'libs/bootstrap',
        typeahead: 'libs/typeahead.min',
        moment: 'libs/moment',
        text: 'libs/text'
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
        }
    }
});

require(["jquery", "app"], function($, App) { 
    "use strict";
    $(function () {
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
