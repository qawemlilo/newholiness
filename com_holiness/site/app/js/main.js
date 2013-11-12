requirejs.config({
    baseUrl: 'components/com_holiness/app/js',
   
    paths: {
        jquery: 'libs/jquery',
        underscore: 'libs/underscore',
        backbone: 'libs/backbone',
        bootstrap: 'libs/bootstrap',
        backboneCache: 'libs/backbone.fetch-cache.min',
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
        
        backboneCache: {
            deps: ['underscore','jquery', 'backbone'],
            exports: 'backboneCache'
        },
        
        bootstrap: {
            deps: ['jquery']
        },
        
        app: {
            deps: ['jquery', 'underscore', 'backbone', 'typeahead']
        }
    }
});

require(["jquery", "app"], function($, App) { 
    "use strict";
    $(function () {
        var devotion = $('#devotionid'), 
            devotionid = devotion.length ? devotion.val() : false;

        App.init(devotionid);
    });
    
});
