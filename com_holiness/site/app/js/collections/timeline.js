
define(["backbone", "models/timeline"], function(Backbone, TimelineItem) {
    "use strict";
    
    var Timeline = Backbone.Collection.extend({
        
        model: TimelineItem,
        
        
        limit: 10,
        
        
        start: 0,
        
        
        url: function () {
            return 'index.php?option=com_holiness&task=home.handleget&start=' + this.start + '&limit=' + this.limit;
        },
        
        
        pushCounter: function () {
            this.start += this.limit;
        }
    });
      
    return Timeline;
});
