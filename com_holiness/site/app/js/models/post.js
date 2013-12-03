
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
        }
    });
      
    return Post;
});
