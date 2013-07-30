
jQuery.noConflict();


(function ($) {

    $.toUpperFirst= function(txt) {
        var txtArr = txt.split(" "),
        words = [];
	    
        _.each(txtArr, function (word) {
            words.push(word.charAt(0).toUpperCase() + word.slice(1))  
        });
        
        return words.join(" ");
    };
    
    var commentHtml = '<div class="span1">';
    commentHtml += '<a href="#/users/<%= id %>"><img src="media/com_holiness/images/user-<%= id %>-icon.<%= imgext %>" class="img-circle" onerror="this.src=\'data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\'" /></a>';
    commentHtml += '</div><div class="span11"><div class="row-fluid"><strong><a href="#/users/<%= id %>"><%= name %></a></strong>';
    commentHtml += '<span class="badge badge-info" style="margin-left:10px;"><a style="color: #fff;" class="amen-plus" href="#">Amen</a></span><br>';
    commentHtml += '<small><%= ts %></small><br><%= comment %></div>';
    
    
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

        template: _.template(commentHtml),
        
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
            this.listenTo(this.collection, 'add', this.render);
            this.listenTo(this.collection, 'reset', this.render);
            
            this.collection.fetch({reset: true});
            
            return this;
        },
        
        render: function () {
            var fragment = document.createDocumentFragment(), commentView, hr;
            
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
    
    
    
    
    $.getComments = function (baseurl, devotionid) {
        var commentsCollection = new CommentsCollection();
        commentsCollection.url = baseurl + '?option=com_holiness&task=user.getcomments&id='+devotionid;
        
        var commentsView = new CommentsView({
            collection: commentsCollection
        });
        
    };    
}(jQuery))
