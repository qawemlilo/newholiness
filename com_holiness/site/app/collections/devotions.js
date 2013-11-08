
require(["underscore", "backbone", "../models/devotion"], function(_, Backbone, Devotion) {
    Devotions = Backbone.Collection.extend({
        model: Devotion,
        
        url: 'index.php?option=com_holiness&task=devotion.getdevotions' 
    });
    
    return Devotions;
});
