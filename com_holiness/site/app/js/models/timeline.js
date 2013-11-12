
define(["backbone"], function(Backbone) {
    var Timeline = Backbone.Model.extend({
        defaults: {
            userid: '',
            name: '',
            post: '',
            imgext: 'jpg',
            posttype: 'prayerrequest',
            ts: ''
        },
        
        urlRoot: 'index.php?option=com_holiness&task=home.handlepost'
    });
      
    return Timeline;
});
