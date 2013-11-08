
require(["underscore", "backbone"], function(_, Backbone) {
    var Users = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    });
      
    return Users;
});
