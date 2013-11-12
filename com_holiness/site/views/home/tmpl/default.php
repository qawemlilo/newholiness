<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();
?>
<div id="timeline" class="row-fluid content-display hide">
  <div id="postbox" style="background-color: #fff; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;">
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
    
    <div id="pointer" style="position:absolute; border:solid 15px transparent; border-bottom-color:#dddddd; margin:-15px 0px 0px 20px; z-index:999;"></div>
    
    <div class="row-fluid" style="margin-top: 13px;">
      <form style="margin-bottom: 0px;" action="" id="postform">
        <textarea rows="2" cols="10" name="post" id="sharebox" class="span12" placeholder="Share your Prayer Request, your Devotion Partners will pray with you!"></textarea>
        <input type="hidden" name="posttype" id="sharetype" value="Prayer Request" />
        <input type="hidden" name="name" value="<?php echo $user->name; ?>" />
        <input type="hidden" name="userid" value="<?php echo $user->id; ?>" />
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
    
    <p><button class="btn btn-primary">Make devotion partner</button></p>
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
      <p>
        <strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>
        <small><%= church %></small><br>
        <button class="btn add-partner" style="margin-top:5px;">Make devotion partner</button>
      </p>
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
    <div  class="row-fluid">
      <strong><a href="#/users/<%= userid %>"><%= name %></a></strong>
      <span class="badge badge-<%= label %>" style="margin-left:10px;">
        <a class="timeline-item-read" style="color:#fff;" href="#<%= id %>"><%= posttype %></a>
      </span>
      <div class="dropdown pull-right">
        <a href="#" class="edit-timeline-item dropdown-toggle" data-toggle="dropdown">
          <i class="icon-chevron-down"></i>
        </a>
        <ul class="dropdown-menu" style="min-width:90px">
          <li><a href="#" class="edit-timeline-item-edit">Edit</a></li>
          <li><a href="#" class="edit-timeline-item-delete">Delete</a></li>
        </ul>
      </div>
    </div>
    <div  class="row-fluid">
      <small><%= ts %> <i class="icon-comments" style="margin-left:5px"></i> <span id="timeline-item-comments-count">0</span> </small><br>
      <%= post %>
    </div>
  </div>
</div>
</script>

<!------------------------------------------------------- ENDOF; JavaScript Templates  ------------------------------------------>


<div id="user-content" class="content-display hide" style="padding:20px; background-color:#fff;">
</div>