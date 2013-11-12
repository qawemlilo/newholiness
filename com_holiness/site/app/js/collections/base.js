
define(["underscore", "backbone"], function(_, Backbone) {
    var DBase = Backbone.DBase = Backbone.Collection.extend({

        perPage: 20,

        
        next: false,

        
        prev: false,
        
        
        currentPage: 0,
        
        
        pages: [],
        
        
        
        init: function () {

            var counter = 0, page = 0, self = this;
            
            _.each(this.models, function (model) {
                
 
                if (counter >= self.perPage) {
                    ++page;
                    counter = 0;
                }
                
                if (!_.isArray(self.pages[page])) {
                    self.pages[page] = [];
                } 
                
                self.pages[page].push(model);
                
                counter++;
            });
            
            this.pager();
        },

        
        
        pager: function (num) {
            if (num && num < this.pages.length) {
                this.currentPage = num;
            }
            
            if (this.currentPage + 1 >= this.pages.length) {
                this.next = false;
            }else {
                this.next = true;
            }
            if (this.currentPage - 1 < 0) {
                this.prev = false;
            } else {
                this.prev = true;
            }
            
            this.reset(this.pages[this.currentPage]);    
        },
        
        
        nextPage: function () {
            if (this.currentPage + 1 >= this.pages.length) {
                return false;
            }

            this.currentPage += 1;

            this.pager();            
        },
        
        
        prevPage: function () {
            if (this.currentPage + 1 < 0) {
                return false;
            }

            this.currentPage -= 1;

            this.pager();          
        }   
    });
    
    return DBase;
});
