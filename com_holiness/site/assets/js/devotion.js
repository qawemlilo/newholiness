
jQuery.noConflict();


(function ($) {

    $.toUpperFirst = $.toUpperFirst || function(txt) {
        var txtArr = txt.toLowerCase().split(" "),
        words = [];
	    
        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1))  
        });
        
        return words.join(" ");
    };
    
    
    var Comment = Backbone.Model.extend({
        defaults: {
            id: 0, 
            ts: 0, 
            comment: "", 
            imgext: "", 
            name: "",
            amens: ""
        }
    }),
    
    
    CommentsCollection = Backbone.Collection.extend({
        model: Comment      
    }), 


    CommentView = Backbone.View.extend({

        className: 'comment row-fluid',

        template: _.template($('#comment-tpl').text()),
        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.name = $.toUpperFirst(data.name);
            data.ts = this.getTime(data.ts);
            
            template = this.template(data);
 
            this.$el.append(template);
            
            return this;
        },

        getTime: function (ts) {
            var ago = moment(ts, "YYYY-MM-DD HH:mm:ss").fromNow();
            
            return ago;
        }        
    }),
    
    
    CommentsView = Backbone.View.extend({
    
        el: $('#commentscontainer'),
        
        initialize: function () {
            var self = this;
                       
            this.collection.fetch({
                cache: true, 
                
                expires: (1000 * 60) * 60 * 24 * 2,
                
                success: function () {
                    self.render();                    
                }
            });
            
            return this;
        },
        
        render: function () {
            var fragment = document.createDocumentFragment(), commentView, hr;
            
            this.$el.empty();
            
            if (this.collection.length > 0) {
                hr = document.createElement('hr');
                
                fragment.appendChild(hr);
            }
            
            this.collection.forEach(function (model) { 
                commentView = new CommentView({
                    model: model
                });
                
                fragment.appendChild(commentView.render().el);
            });
            
            this.$el.html(fragment);
            
            return this;
        }        
    });
    
    
    
    
    $.getComments = function (devotionid) {
        var commentsCollection = new CommentsCollection();
        commentsCollection.url = 'index.php?option=com_holiness&task=user.getcomments&id=' + devotionid;
        
        var commentsView = new CommentsView({
            collection: commentsCollection
        });
        
    };    
}(jQuery))
