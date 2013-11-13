
define(["underscore", "backbone", "models/user"], function(_, Backbone, User) {
    Backbone.Collection.prototype.getUsers = function (num) {

        this.models = _.shuffle(this.models);
            
        var currentmodels = this.models.slice(0, num || 12); 
        
        return currentmodels;  
    }; 
    
    var Users = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    });
      
    return Users;
});
