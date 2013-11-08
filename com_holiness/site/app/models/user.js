
require(["underscore", "backbone"], function(_, Backbone) {
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            memberid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    });
      
    return User;
});
