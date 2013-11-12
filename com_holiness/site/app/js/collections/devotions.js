
define(["backbone", "models/devotion"], function(Backbone, Devotion) {
    Devotions = Backbone.Collection.extend({
        model: Devotion,
        
        url: 'index.php?option=com_holiness&task=devotion.getdevotions' 
    });
    
    return Devotions;
});
