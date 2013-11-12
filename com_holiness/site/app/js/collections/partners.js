
define(["underscore", "backbone", "models/user"], function(_, Backbone, User) {
    Partners = Backbone.Collection.extend({
        model: User      
    });
    
    return Partners;
});
