
define(["backbone", "models/devotion"], function(Backbone, Devotion) {
    "use strict";
    
    var Blessings = Backbone.Collection.extend({
        model: Devotion,
        
        url: 'index.php?option=com_holiness&task=devotion.blessed' 
    });
    
    return Blessings;
});
