requirejs.config({
    appDir: '../',
    
    baseUrl: 'js',
   
    paths: {
        jquery : 'libs/jquery',
        underscore: 'libs/underscore',
        backbone: 'libs/backbone',
        bootstrap: 'libs/bootstrap',
        backboneCache: 'libs/backbone.fetch-cache.min',
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
        
        backbone: {
            deps: ['underscore','jquery'],
            exports: 'Backbone'
        },
        
        backboneCache: {
            deps: ['underscore','jquery', 'backbone'],
            exports: 'backboneCache'
        },
        
        bootstrap: {
            deps: ['jquery']
        }
    }
});

require(["jquery", "app"], function($, App) {  
    $(function() {
        "use strict";
        
        App = new App();
        
        $.initApp = function () {
            return App;
        };
    });
});
