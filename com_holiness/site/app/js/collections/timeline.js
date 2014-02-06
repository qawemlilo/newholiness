
define(["backbone", "models/timeline"], function(Backbone, TimelineItem) {
    "use strict";
    
    var Timeline = Backbone.Collection.extend({
        
        model: TimelineItem,
        
        complete: false,
        
        
        limit: 10,
        
        
        start: 0,
        
        
        url: function () {
            return 'index.php?option=com_holiness&task=timeline.fetch&start=' + this.start + '&limit=' + this.limit;
        },
        
        
        pushCounter: function () {
            this.start += this.limit;
        },
        
        
        isComplete: function (flag) {
            if (flag) {
                this.complete = flag;
            }
            
            return this.complete;
        }
    });
      
    return Timeline;
});
