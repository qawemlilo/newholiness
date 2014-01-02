
define(["backbone", "models/devotion"], function(Backbone, Devotion) {
    "use strict";
    
    var Devotions = Backbone.Collection.extend({
        model: Devotion,
        
        url: 'index.php?option=com_holiness&task=devotion.getdevotions' 
    });
    
    return Devotions;
});
