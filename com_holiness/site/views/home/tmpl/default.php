<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('#showdevotions ul {margin-left:10px;}');
?>
<div id="timeline" class="row-fluid content-display hide">
  <div class="timeline-item" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;">
    <div class="row-fluid">
      <div class="span3">
        <div class="row-fluid"><span style="color: #000;"><i class="icon-book"></i></span> Prayer Request</div>
        <div class="row-fluid"></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: green;"><i class="icon-bullhorn"></i></span> Testimony</div>
        <div class="row-fluid"></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: orange;"><i class="icon-hand-right"></i></span> Prophecy</div>
        <div class="row-fluid"></div>
      </div>
      <div class="span3">
        <div class="row-fluid"><span style="color: red;"><i class="icon-eye-open"></i></span> Revelation</div>
        <div class="row-fluid"></div>
      </div>
    </div>
    <div class="row-fluid">
      <form style="margin-bottom: 0px;">
        <textarea rows="2" cols="10" class="span12" placeholder="Share your Prayer Request, your Devotion Partners will pray with you!"></textarea>
      </form>
    </div>
    <div class="row-fluid">
      <div class="span9">
      </div>
      <div class="span3" style="text-align:right">
        <button style="padding-right: 40px; padding-left: 40px;" class="btn btn-large btn-primary" type="button">Share</button>
      </div>
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
    <h3 style="margin-top: 0px">The Divine Profile for <%= value %> who is born of God</h3>
    
    <blockquote>
      My name is <%= value %> and I am Born-Again by God's Love & Grace. I go to <%= church %> and I love my Church so much.
    </blockquote>
    <p><button class="btn btn-info">Make <%= value.split(" ")[0] %> your devotion partner</button></p>
    <br>
    <ul class="nav nav-tabs" style="margin-bottom: 0px">
      <li class="active">
        <a href="#showdevotions"><i class="icon-book"> </i> Devotions</a>
      </li>
      <li>
        <a href="#showpartners"><i class="icon-user"> </i> Devotion Partners</a>
      </li>
    </ul>
    
    <div class="tab-content" style="margin-top: 0px; padding: 20px 0px 10px 0px; border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd;">
      <div class="tab-pane active" id="showdevotions">
        <div style="margin-left:10px"><img src="<?php echo JURI::base(); ?>components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></div>
      </div>
      <div class="tab-pane" id="showpartners">
        <div style="margin-left:10px"><img src="<?php echo JURI::base(); ?>components/com_holiness/assets/images/loading.gif" style="width:80px; height:12px;" /></div>
      </div>
    </div>    
  </div>
</div>
</script>

<script type="text/html" id="partners-tpl">
  <div class="row-fluid fellow">
    <div class="span3">
      <img src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" onerror="this.src='modules/mod_hpmembers/assets/images/none.jpg'" />
    </div>
    
    <div class="span9"><div class="row-fluid">
      <p><strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>
      <small><%= church %></small></p>
      <p><button class="btn add-partner"><small>Make devotion partner</small></button></p>
    </div>
  </div>
</script>
<!------------------------------------------------------- ENDOF; JavaScript Templates  ------------------------------------------>


<div id="user-content" class="row-fluid content-display hide">
</div>
<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/libs/backbone.fetch-cache.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/home.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        $.initApp('<?php echo JURI::base(); ?>?option=com_holiness&task=user.getusers');
    });
}(jQuery));
</script> 
