
define(["backbone"], function(Backbone) {
    var Post = Backbone.Model.extend({
    
        defaults: {
            userid: '',
            memberid: '',
            name: '',
            post: '',
            imgext: 'jpg',
            posttype: 'prayerrequest',
            willpray: 0,
            haveprayed: 0,
            comments: 0,
            ts: ''
        },
        
        
        sync: function(method, model, options) {
            var self = this;
            
            if (!options) {
                options = {};
            }
            
            switch (method) {
                case 'read':
                    self.fetchItem(model.get('id'), model, options);
                break;
                
                case 'update':
                case 'delete':
                case 'create':
                case 'put':
                    Backbone.sync.apply(self, arguments);
                break;
            }
        },
        
        
        fetchItem: function(itemId, model, opts) {
            $.post('index.php?option=com_holiness&task=home.handlepostitem', {id: itemId})
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
            $.post('index.php?option=com_holiness&task=home.handleput', {id: itemId, post: model.get('post')})
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
        
        
        urlRoot: 'index.php?option=com_holiness&task=home.handlepostitem'
    });
      
    return Post;
});
