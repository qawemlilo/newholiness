<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<div id="timeline" class="row-fluid content-display hide">
  <div class="timeline-item" id="postbox" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;">
    <div class="row-fluid post-actions" style="margin-bottom: 0px;">
      <div class="span3">
        <div class="row-fluid"><span style="color: #000;"><i class="icon-book"></i></span> <a href="#" class="active" style="color:#414141">Prayer Request</a></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: green;"><i class="icon-bullhorn"></i></span> <a href="#">Testimony</a></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: orange;"><i class="icon-hand-right"></i></span> <a href="#">Prophecy</a></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: red;"><i class="icon-eye-open"></i></span> <a href="#">Revelation</a></div>
      </div>
    </div>
    
    <div id="pointer" style="position:absolute; border:solid 15px transparent; border-bottom-color:#fff; margin:-15px 0px 0px 20px; z-index:999;"></div>
    
    <div class="row-fluid" style="margin-top: 13px;">
      <form style="margin-bottom: 0px;" action="" id="postform">
        <textarea rows="2" cols="10" name="message" id="sharebox" class="span12" placeholder="Share your Prayer Request, your Devotion Partners will pray with you!"></textarea>
        <input type="hidden" name="sharetype" id="sharetype" value="Prayer Request" >
        <div class="row-fluid">
            <div class="span9">
               <strong>Characters: <span id="chars">150</span></strong>
            </div>
            <div class="span3" style="text-align:right">
                <button style="padding-right: 40px; padding-left: 40px;" class="btn btn-large btn-primary" type="submit">Share</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!------------------------------------------------------- JavaScript Templates  ------------------------------------------>
<script type="text/html" id="user-tpl">
<div class="row-fluid" id="memberprofile">
  <div class="span3">
    <img style="width:150px; height:150px" src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" class="img-polaroid" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" />
    <br>
    <blockquote>
      <p><strong><a href="#/users/<%= id %>"><%= value %></a></strong></p>
      <small><%= church %></small>
    </blockquote>
  </div>
  
  <div class="span9">
    <h3 style="margin-top: 0px">The Divinee Profile for <%= value %> who is born of God</h3>
    
    <blockquote>
      My name is <%= value %> and I am Born-Again by God's Love & Grace. I go to <%= church %> and I love my Church so much.
    </blockquote>
    <p><button class="btn btn-info">Make <%= value.split(" ")[0] %> your devotion partner</button></p>
    
    <br />
    
    <ul class="nav nav-tabs" style="margin-bottom: 0px">
      <li class="active">
        <a href="#showdevotions"><i class="icon-book"> </i> Devotions</a>
      </li>
      <li>
        <a href="#showpartners"><i class="icon-user"> </i> Devotion Partners</a>
      </li>
    </ul>
    
    <div class="tab-content" style="margin-top: 0px; padding: 20px 0px 0px 0px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd;">
      <div class="tab-pane active" id="showdevotions">
      </div>
      <div class="tab-pane" id="showpartners">
      </div>
    </div>    
  </div>
</div>
</script>

<script type="text/html" id="partners-tpl">
  <div class="row-fluid fellow" style="margin-bottom:10px;">
    <div class="span2">
      <img class="img-polaroid" src="<?php echo JURI::base() ?>media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" onerror="this.src='modules/mod_hpmembers/assets/images/none.jpg'" />
    </div>
    
    <div class="span9" style="margin-bottom:10px; margin-left:20px">
      <p><strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>
      <small><%= church %></small><br>
      <button class="btn add-partner" style="margin-top:5px;"><small>Make devotion partner</small></button></p>
    </div>
  </div>
</script>

<script type="text/html" id="pagination-tpl">
<% if (prev) { %>
<li class="previous">
<a href="#" style="margin-left: 10px">&larr; Prev</a>
</li>
<% }if (nxt) { %>
<li class="next">
 <a href="#" style="margin-right: 10px">Next &rarr;</a>
</li>
<% } %>
</script>


<script type="text/html" id="timeline-item-tpl">
<div  class="row-fluid">
  <div class="span1">
    <a href="#/users/<%= id %>">
    <img src="<?php echo JURI::base() ?>media/com_holiness/images/user-<%= id %>-icon.<%= imgext %>" class="img-circle" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='">
    </a>
  </div>
  
  <div class="span11">
    <strong><a href="#/users/<%= id %>"><%= name %></a></strong>
    <span class="badge badge-<%= label %>" style="margin-left:10px;">
      <a class="timeline-item-read" style="color:#fff;" href="<%= url %>">#<%= sharetype %></a>
    </span>
    <br>
    <small><%= ts %></small>
    <br>
    <%= message %>
  </div>
</div>
</script>

<!------------------------------------------------------- ENDOF; JavaScript Templates  ------------------------------------------>


<div id="user-content" class="row-fluid content-display hide">
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/main.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
    
        $.initApp();
        
        
        var TimelineItem = Backbone.Model.extend({
            defaults: {
                name: '',
                message: '',
                imgext: 'jpg',
                sharetype: 'Prayer Request',
                url: '#',
                ts: new Date().getTime()
            }
        });
        
        
        var TimelineCollection = Backbone.Collection.extend({
            model: TimelineItem,
            
            sync: function (method, model, options) {
            
                options || (options = {});
                switch (method) {
                    case 'create':
                    break;
                
                    case 'update':
                    break;
                
                    case 'delete':
                    break;
                
                    case 'read':
                    break;
                }
            }
        });
        
        
        var TimelineItemView =  Backbone.View.extend({
        
            className: 'timeline-item',
            
            
            labelColor: {
                'Prayer Request': 'important',
                
                'Prophecy': 'inverse',
                
                'Revelation': 'info',
                
                'Testimony': 'success'
            },
            
        
            template: _.template($('#timeline-item-tpl').text()),
            
            
            render: function () {
                var data = this.model.toJSON(),
                    template,
                    time = new Date().getTime();
                    
                data.ts = moment(time).fromNow();
                data.label = this.labelColor[data.sharetype];
                template = this.template(data);
                
                this.$el.append(template);

                return this;                
            }
        });
        
        
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
                var marginleft = '20px', 
                    self = this,
                    plcHolder = 'Share your Prayer Request, your Devotion Partners will pray with you!',
                    tab = $(event.currentTarget).text();

                self.$('.post-actions a.active').removeClass('active').css('color', '#08c');
                $(event.currentTarget).addClass('active').css('color', '#414141');
            
                if (tab === 'Testimony') {
                   marginleft = '200px';
                   plcHolder = 'Share your Testimony! Share with your Devotion Partners what the Lord has done for you!'
                }
                
                if (tab === 'Prophecy') {
                   marginleft = '370px';
                   plcHolder = 'Become the mouthpiece of God to your Devotion Partners! Prophecy...'
                }
                
                if (tab === 'Revelation') {
                   marginleft = '550px';
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
            
                <?php 
                    //smart use of php inside javascript
                    $user =& JFactory::getUser(); 
                ?>
                var data = this.formToObject();
                
                data.id = <?php echo $user->id; ?>;
                data.name = '<?php echo $user->name; ?>';
                
                var view = new TimelineItemView({
                    model: new TimelineItem(data)
                });
                
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
        
        new PostBox();
    });
}(jQuery));
</script> 
