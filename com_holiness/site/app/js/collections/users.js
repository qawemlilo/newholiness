
define(["underscore", "backbone", "models/user"], function(_, Backbone, User) {
    var Users = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    });
      
    return Users;
});
