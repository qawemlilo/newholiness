
jQuery.noConflict();

(function ($) {
    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            userid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    });

    
    var Users = Backbone.Collection.extend({
    
        model: User,
        
        
        url: 'index.php?option=com_holiness&task=user.getusers'        
    });
    
    var members = new Users();
    
    members.fetch({reset: true}); 

    $.getUser = function (id) {
        return members.get(id);
    };     
}(jQuery))