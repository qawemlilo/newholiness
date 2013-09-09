<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<div id="timeline" class="row-fluid content-display hide">
  <div id="postbox" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;">
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
        <textarea rows="2" cols="10" name="post" id="sharebox" class="span12" placeholder="Share your Prayer Request, your Devotion Partners will pray with you!"></textarea>
        <input type="hidden" name="posttype" id="sharetype" value="Prayer Request" >
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
    
    <p><button class="btn btn-info">Make devotion partner</button></p>
  </div>
  
  <div class="span9">
    <h3 style="margin-top: 0px">The Divinee Profile for <%= value %> who is born of God</h3>
    
    <blockquote>
      My name is <%= value %> and I am Born-Again by God's Love & Grace. I go to <%= church %> and I love my Church so much.
    </blockquote> 
    
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
    <a href="#/users/<%= userid %>">
    <img src="<?php echo JURI::base() ?>media/com_holiness/images/user-<%= userid %>-icon.<%= imgext %>" class="img-circle" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='">
    </a>
  </div>
  
  <div class="span11">
    <strong><a href="#/users/<%= userid %>"><%= name %></a></strong>
    <span class="badge badge-<%= label %>" style="margin-left:10px;">
      <a class="timeline-item-read" style="color:#fff;" href="#<%= id %>"><%= posttype %></a>
    </span>
    <br>
    <small><%= ts %></small>
    <br>
    <%= post %>
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
        
        Backbone.emulateHTTP = true; 
        
        var TimelineItem = Backbone.Model.extend({
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
        
        
        var TimelineCollection = Backbone.Collection.extend({
        
            model: TimelineItem,
            
            
            ogModels: [],
            
            
            displayLimit: 2,
            
            
            currentDisplayed: 0,
            
            
            url: 'index.php?option=com_holiness&task=home.handleget',
            
            
            initialize: function () {
                this.currentDisplayed = 0;
                this.ogModels = [];
            },
            
            
            getMore: function () {
                if (!(this.ogModels.length > 0)) {
                    this.ogModels = this.clone().models;
                }
                else {
                    this.models = this.ogModels;
                }
                
                var limit = (this.currentDisplayed + this.displayLimit);
                
                if (limit >= this.ogModels.length) {
                    limit = this.ogModels.length;
                }
                
                this.currentDisplayed = limit;

                var currentModels = this.models.slice(0, limit);
	    
	            this.reset(currentModels);
            }
        });
        
        
        var TimelineItemView =  Backbone.View.extend({
        
            className: 'timeline-item',
            
            
            labelColor: {
                'prayerrequest': 'important',
                
                'prophecy': 'inverse',
                
                'revelation': 'info',
                
                'testimony': 'success'
            },
            
            
            postLabel: {
                'prayerrequest': 'Prayer Request',
                
                'prophecy': 'Prophecy',
                
                'revelation': 'Revelation',
                
                'testimony': 'Testimony'
            },
            
        
            template: _.template($('#timeline-item-tpl').text()),
            
            
            render: function () {
                var data = this.model.toJSON(),
                    template;
                    
                if (!data.id) {
                    data.id = 0; 
                }
                
                
                data.ts = this.timeAgo(data.ts);
                data.label = this.labelColor[data.posttype];
                data.posttype = this.postLabel[data.posttype];
                template = this.template(data);
                
                this.$el.append(template);

                return this;                
            },
            
            
            timeAgo: function (ts) {
                var ago;
                
                if (ts) {
                    ago = moment.unix(parseInt(ts, 10)).fromNow();
                }
                else {
                    ago = moment(new Date().getTime()).fromNow();
                }
                
                return ago;     
            }
        });
        
        
        
        var TimelineCollectionView =  Backbone.View.extend({
        
            el: '#timeline',
            
            
            events: {
                "click .btn-block": "loadMore"
            },
            
            
            initialize: function () {
                this.listenTo(this.collection, "reset", this.render);
            },
            
            
            render: function () {
                var fragment = this.viewAll();
                
                $('.timeline-item, .btn-block').remove();
                this.$el.append(fragment);
                
                return this;                
            },
            
            
            
            
            viewAll: function () {
                var fragment = document.createDocumentFragment(), button = document.createElement('button');
            
                this.collection.forEach(function (postModel) { 
                    var postView = new TimelineItemView({model: postModel});
                    //console.log(postModel);
                    fragment.appendChild(postView.render().el);
                });
                
                button.className = "btn btn-block";
                button.innerHTML = "Load More";
                fragment.appendChild(button);
                
                return fragment;
            },
            
            
            
            loadMore: function (e) {
                this.collection.getMore();
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
                   marginleft = '24%';
                   plcHolder = 'Become the mouthpiece of God to your Devotion Partners! Prophecy...'
                }
                
                if (tab === 'Revelation') {
                   marginleft = '35%';
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
                
                data.userid = <?php echo $user->id; ?>;
                data.name = '<?php echo $user->name; ?>';
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
        
        var pb = new PostBox();
        var tlView = new TimelineCollectionView({
            collection: new TimelineCollection()
        });
        tlView.collection.fetch({reset: true});
    });
}(jQuery));
</script> 
