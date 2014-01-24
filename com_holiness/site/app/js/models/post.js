
define(["jquery", "backbone"], function($, Backbone) {
    var Post = Backbone.Model.extend({
    
        defaults: {
            userid: '',
            memberid: '',
            name: '',
            post: '',
            imgext: 'jpg',
            posttype: '',
            plusones: [],
            haveprayed: 0,
            comments: '',
            ts: ''
        }
    });
      
    return Post;
});
