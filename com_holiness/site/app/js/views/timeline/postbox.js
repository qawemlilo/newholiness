
define([
    "jquery",
    "underscore", 
    "backbone",
    "models/timeline",
    "text!tmpl/timeline/postbox.html",
    "moment",
    "wordlimit",
    "noty",
    "notyTheme",
    "notyPosition"
], function ($, _, Backbone, TimelineItem, Template) {
    "use strict";

    var PostBox =  Backbone.View.extend({
    
        tagName: 'div',
        
        
        id: 'postbox',
        
        
        className: 'postbox-cont',
        
        
        template: _.template(Template),
        
        
        events: {
            'click .post-actions a': 'changeTab',
            'submit #postform': 'submitPost'
        },
        
        
        initialize: function (opts) {
            this.postsView = opts.posts;
        },
        
        
        render: function () {
            var data = {
                id: HolinessPageVars.id,
                name: HolinessPageVars.name,
                imgext: HolinessPageVars.imgext
            };
            
            this.$el.html(this.template(data));
            
            this.$('#sharebox').wordLimit({
                counterDiv: '#chars'
            });
            
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
            
            if (tab === 'Motivation') {
               marginleft = '38%';
               plcHolder = 'Share with your Devotion Partners your Motivation!';
            }
        
            self.$('#pointer').animate({
                marginLeft: marginleft
            }, 500, function () {
                $('#sharetype').val(tab);
                self.$('#sharebox').val('').attr('placeholder', plcHolder).focus();
                self. $('#chars').html('150');
            });  
        },
        
        
        
        
        submitPost: function (event) {
        
            event.preventDefault();
            
            var self = this, data = self.formToObject(), model;

            data.posttype = data.posttype.toLowerCase().replace(/ /g, '');
            
            model = new TimelineItem(data);
            
            model.save(null, {
                success: function(model, data) {
                    model.set(data.id);
                    self.postsView.addNew(model);
                    noty({text: 'Your post has been shared succefully!', type: 'success'});
                },
                error: function () {
                    noty({text: 'Error. Post not saved', type: 'error'});
                }
            });
            
            self.$('#sharebox').val('');
            self.$('#chars').html('150');
            
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
