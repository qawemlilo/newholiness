
jQuery.noConflict();

(function ($) {

    var User = Backbone.Model.extend({
        defaults: {
            id: 0, 
            userid: 0, 
            church: "", 
            imgext: "", 
            value: ""
        }
    });
    
    
    var Comment = Backbone.Model.extend({
        defaults: {
            id: 0, 
            ts: 0, 
            comment: "", 
            imgext: "", 
            name: "",
            
        }
    });


    var CommentView = Backbone.View.extend({

        className: 'comment row-fluid',


        template: _.template('<div class="span1"><img src="media/com_holiness/images/user-<%= id %>-icon.<%= imgext %>" class="img-circle" onerror="this.src=\'data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\'" /></div><div class="span11"><p><strong class="pull-left"><%= name %></strong> <span class="pull-right"><%= ts %></span></p><p><%= comment %></p></div>'),

        
        render: function () {
            var template, data = this.model.toJSON();
            
            data.ts = this.getTime(data.ts);
            template = this.template(data);
 
            this.$el.append(template);
            
            return this;
        },
        

        getTime: function (ts) {
            var ago = moment(ts, "YYYY-MM-DD HH:mm:ss").fromNow();
            
            return ago;
        }        
    });
    
    
    
    var CommentsView = Backbone.View.extend({
    
        el: $('#commentscontainer'),
        

     
        initialize: function () {            
            this.listenTo(this.collection, 'add', this.render);
            this.listenTo(this.collection, 'reset', this.render);
            
            this.collection.fetch({reset: true});
            
            return this;
        },
        
        
        
        
        render: function () {
            var fragment = document.createDocumentFragment(), commentView;
            
            if (this.collection.length > 0) {
                var hr = document.createElement('hr');
                
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

    
    
    
    var Users = Backbone.Collection.extend({
        model: User,

        url: 'index.php?option=com_holiness&task=user.getusers'        
    });
    
    
    
    
    var CommentsCollection = Backbone.Collection.extend({
        model: Comment      
    });
    
    
    
    
    //var members = new Users();
    
    
    
    //members.fetch({reset: true}); 
    
    

    //$.getUser = function (id) {
       // return members.get(id);
    //}; 
    
    
    
    $.getComments = function (devotionid) {
        var commentsCollection = new CommentsCollection();
        commentsCollection.url = 'index.php?option=com_holiness&task=user.getcomments&id='+devotionid;
        
        var commentsView = new CommentsView({
            collection: commentsCollection
        });
        
    };    
}(jQuery))
