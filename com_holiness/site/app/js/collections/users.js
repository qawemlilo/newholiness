
define(["collections/backbone-fetchcache", "models/user"], function(Backbone, User) {
    "use strict";

    var Users = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    });
      
    return Users;
});
