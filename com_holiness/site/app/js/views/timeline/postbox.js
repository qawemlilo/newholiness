
define([
    "jquery",
    "underscore", 
    "backbone",
    "models/timeline",
    "text!tmpl/timeline/postbox.html",
    "moment",
    "wordlimit"
], function ($, _, Backbone, TimelineItem, Template) {
    "use strict";

    var PostBox =  Backbone.View.extend({
    
        tagName: 'div',
        
        
        id: 'postbox',
        
        
        className: 'postbox-cont',
        
        
        template: _.template(Template),
        
        
        sharebox: $('#sharebox'),
        
        
        charsDiv: $('#chars'),
        
        
        events: {
            'click .post-actions a': 'changeTab',
            'submit #postform': 'submitPost'
        },
        
        
        initialize: function (opts) {
            this.$('#sharebox').wordLimit({
                counterDiv: '#chars'
            });
        },
        
        
        render: function () {
            var data = {
                id: HolinessPageVars.id,
                name: HolinessPageVars.name,
                imgext: HolinessPageVars.imgext
            };
            
            this.$el.html(this.template(data));
            
            return this;                
        },
        
        
        changeTab: function (event) {
            event.preventDefault();
            
            var marginleft = '2%', 
                self = this,
                plcHolder = 'Share your Prayer Request, your Devotion Partners will pray with you!',
                tab = $(event.currentTarget).text();

            self.$('.post-actions a.active').removeClass('active').css('color', '#08c');
            $(event.currentTarget).addClass('active').css('color', '#414141');
        
            if (tab === 'Testimony') {
               marginleft = '13%';
               plcHolder = 'Share your Testimony! Share with your Devotion Partners what the Lord has done for you!';
            }
            
            if (tab === 'Prophecy') {
               marginleft = '25%';
               plcHolder = 'Become the mouthpiece of God to your Devotion Partners! Prophecy...';
            }
            
            if (tab === 'Revelation') {
               marginleft = '38%';
               plcHolder = 'Share with your Devotion Partners that Revelation you just received in your Spirit!';
            }
        
            self.$('#pointer').animate({
                marginLeft: marginleft
            }, 500, function () {
                $('#sharetype').val(tab);
                self.sharebox.val('').attr('placeholder', plcHolder).focus();
                self.charsDiv.html('150');
            });  
        },
        
        
        
        
        submitPost: function (event) {
        
            event.preventDefault();
            
            var data = this.formToObject();

            data.posttype = data.posttype.toLowerCase().replace(/ /g, '');
            
            
            var model = new TimelineItem(data);
            
            model.save();
            
            this.sharebox.val('');
            this.charsDiv.html('150');
            
            this.collection.add(model);
            
            document.forms['postform'].reset();
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
