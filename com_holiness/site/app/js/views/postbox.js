
define([
    "jquery",
    "underscore", 
    "backbone",
    "models/timeline",
    "views/timeline",
    "moment"
], function ($, _, Backbone, TimelineItem, TimelineItemView) {
    "use strict";

    var PostBox =  Backbone.View.extend({
    
        el: '#postbox',
        
        
        sharebox: $('#sharebox'),
        
        
        charsDiv: $('#chars'),
        
        
        events: {
            'click .post-actions a': 'changeTab',
            
            'keyup #sharebox': 'countLength',
            
            'submit #postform': 'submitPost'
        },
        
        
        changeTab: function (event) {
            var marginleft = '2%', 
                self = this,
                plcHolder = 'Share your Prayer Request, your Devotion Partners will pray with you!',
                tab = $(event.currentTarget).text();

            self.$('.post-actions a.active').removeClass('active').css('color', '#08c');
            $(event.currentTarget).addClass('active').css('color', '#414141');
        
            if (tab === 'Testimony') {
               marginleft = '13%';
               plcHolder = 'Share your Testimony! Share with your Devotion Partners what the Lord has done for you!'
            }
            
            if (tab === 'Prophecy') {
               marginleft = '25%';
               plcHolder = 'Become the mouthpiece of God to your Devotion Partners! Prophecy...'
            }
            
            if (tab === 'Revelation') {
               marginleft = '38%';
               plcHolder = 'Share with your Devotion Partners that Revelation you just received in your Spirit!'
            }
        
            self.$('#pointer').animate({
                marginLeft: marginleft
            }, 500, function () {
                $('#sharetype').val(tab);
                self.sharebox.val('').attr('placeholder', plcHolder).focus();
                self.charsDiv.html('150');
            });  
            
            return false;
        },
        
        
        countLength: function (event) {
            var self = this,
                len = self.sharebox.val().length, 
                diff = 150 - parseInt(len, 10);
                 
            if (diff < 0) {
                self.sharebox.val(self.sharebox.val().substring(0, 150));
                diff = 0;
            }
        
            self.charsDiv.html(diff);
            
            return false;
        },
        
        
        
        
        submitPost: function (event) {
        
            event.preventDefault();
            
            var data = this.formToObject();

            data.posttype = data.posttype.toLowerCase().replace(/ /g, '');
            
            var view = new TimelineItemView({
                model: new TimelineItem(data)
            });
            
            view.model.save();
            
            this.sharebox.val('');
            this.charsDiv.html('150');
            
            $('#timeline').append(view.render().el);
            
            return false;
        },
        
    
        formToObject: function () {
            var formObj = {}, arr = $('#postform').serializeArray();
        
            _.each(arr, function (fieldObj) {
                if (fieldObj.name !== 'submit') {
                    formObj[fieldObj.name] = fieldObj.value;
                }
            });
        
            return formObj;
        }
    });
    
    return PostBox;
});
