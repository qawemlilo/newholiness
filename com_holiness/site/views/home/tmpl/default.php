<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('#showdevotions ul, #showpartners ul {margin-left:10px;}; .row-fluid a.active {color:#414141!important}');
?>
<div id="timeline" class="row-fluid content-display hide">
  <div class="timeline-item " style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;">
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
      <form style="margin-bottom: 0px;">
        <textarea rows="2" cols="10" name="sharebox" id="sharebox" class="span12" placeholder="Share your Prayer Request, your Devotion Partners will pray with you!"></textarea>
        <input type="hidden" name="sharetype" id="sharetype" value="prayer" >
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
<div class="row-fluid">
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
      <img class="img-polaroid" src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" onerror="this.src='modules/mod_hpmembers/assets/images/none.jpg'" />
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

<!------------------------------------------------------- ENDOF; JavaScript Templates  ------------------------------------------>


<div id="user-content" class="row-fluid content-display hide">
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/main.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        $.initApp();
        var links = $('.post-actions a'), sharebox = $('#sharebox');
        
        links.on('click', function () {
            var tab = $(this).text();
            
            $('.post-actions a.active').removeClass('active').css('color', '#08c');
            $(this).addClass('active').css('color', '#414141');
            
            showTab(tab);
            
            return false;
        });
        
        
        sharebox.on('keyup', function (e) {
            var len = sharebox.val().length, diff = 150 - parseInt(len, 10);
                     
            if (diff < 0) {
                sharebox.val(sharebox.val().substring(0, 150));
                diff = 0;
            }
            
            $('#chars').html(diff);
        });
        
        
        function showTab(tab) {
            var marginleft = '20px', plcHolder = 'Share your Prayer Request, your Devotion Partners will pray with you!';

            
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
            
            $('#pointer').animate({
                marginLeft: marginleft
            }, 500, function () {
                sharebox.val('').attr('placeholder', plcHolder).focus();
                $('#chars').html('150');
            });         
        }
        
/*
        
        var PostBox =  Backbone.View.extend({
            el: '#postbox',
            
            
            sharebox: $('#chars'),
            
            
            events: {
                'click a': 'changeTab',
                'keyup #sharebox': 'countLength'
            },
            
            
            changeTab: function (e) {
                var marginleft = '20px', 
                    self = this,
                    plcHolder = 'Share your Prayer Request, your Devotion Partners will pray with you!',
                    tab = $(e.currentTarget).text();

                $('.postbox a.active').removeClass('active').css('color', '#08c');
                $(e.currentTarget).addClass('active').css('color', '#414141');
            
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
            
                $('#pointer').animate({
                    marginLeft: marginleft
                }, 500, function () {
                    $('#chars').val('').attr('placeholder', plcHolder).focus();
                    $('#chars').html('150');
                });  
                
                return false;
            },
            
            
            countLength: function (e) {
                var len = $('#chars').val().length, diff = 150 - parseInt(len, 10);
                     
                if (diff < 0) {
                    $('#chars').val($('#chars').val().substring(0, 150));
                    diff = 0;
                }
            
                $('#chars').html(diff);
                
                return false;
            }
        });
        
        new PostBox();*/
        
        
    });
}(jQuery));
</script> 
