
define(["jquery","backbone"], function($, Backbone) {
    "use strict";
    
    var Comment = Backbone.Model.extend({
        defaults: {
            id: '',
            userid: '', 
            ts: '', 
            comment: '',
            'comment_type': '', 
            imgext: '', 
            name: '',
            amens: ''
        },
        
        
        sync: function(method, model, options) {
            var self = this;
            
            if (!options) {
                options = {};
            }
            
            switch (method) {
                case 'delete':
                    self.deleteItem(model.get('id'), model, options);
                break;
                
                case 'update':
                case 'put':
                    self.saveEdit(model.get('id'), model, options);
                break;
                
                case 'read':
                case 'create':
                    Backbone.sync.apply(self, arguments);
                break;
            }
        },
        
        
        deleteItem: function(itemId, model, opts) {
            $.post('index.php?option=com_holiness&task=comments.remove', {id: itemId})
            .done(function(data){
                if (opts.success) {
                    opts.success(model, data);
                }
            })
            .fail(function () {
                if (opts.error) {
                    opts.error(model, 'Error');
                }
            });    
        },
        
        
        saveEdit: function(itemId, model, opts) {
            $.post('index.php?option=com_holiness&task=comments.update', {id: itemId, txt: model.get('comment')})
            .done(function(data){
                if (opts.success) {
                    opts.success(model, data);
                }
            })
            .fail(function () {
                if (opts.error) {
                    opts.error(model, 'Error');
                }
            });    
        }
    });
      
    return Comment;
});
