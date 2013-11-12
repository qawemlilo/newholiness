
define(["backbone", "models/timeline"], function(Backbone, TimelineItem) {
    var Timeline = Backbone.Collection.extend({
        
        model: TimelineItem,
        
        
        ogModels: [],
        
        
        displayLimit: 2,
        
        
        currentDisplayed: 0,
        
        
        url: 'index.php?option=com_holiness&task=home.handleget',
        
        
        initialize: function () {
            this.currentDisplayed = 0;
            this.ogModels = [];
        },
        
        
        getMore: function () {
            if (!(this.ogModels.length > 0)) {
                this.ogModels = this.clone().models;
            }
            else {
                this.models = this.ogModels;
            }
            
            var limit = (this.currentDisplayed + this.displayLimit);
            
            if (limit >= this.ogModels.length) {
                limit = this.ogModels.length;
            }
            
            this.currentDisplayed = limit;

            var currentModels = this.models.slice(0, limit);
	    
	        this.reset(currentModels);
        }
    });
      
    return Timeline;
});
