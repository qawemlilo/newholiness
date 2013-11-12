
define(["backbone", "models/user"], function(Backbone, User) {
    Backbone.Collection.prototype.getUsers = function (num) {

        if (!this.ogModels) {
            this.models = _.shuffle(this.models);
            this.ogModels = this.clone().models;
        }
            
        var currentmodels = this.ogModels.splice(0, num);
            
            
        this.reset(currentmodels);    
    }; 
    
    var Users = Backbone.Collection.extend({
        model: User,
        url: 'index.php?option=com_holiness&task=user.getusers'
    });
      
    return Users;
});
