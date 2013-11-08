

define([
    "jquery", 
    "underscore", 
    "backbone",
    "./views/users",
    "./views/home",
    "./router"
], function($, _, Backbone, UserView, HomeView, Router) {
    "use strict";
    
    var App = {
        models: {},
        views: {},
        collections: {},
        router: {}
    };

    
    var init = function () {
        
        App.views.user = new UserView();
        App.views.home = new HomeView();
        
        App.router = new Router(App);
        
        Backbone.history.start();
        
        return App;
    };
    
    return init;
})
