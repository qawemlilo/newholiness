<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('#commentscontainer .comment {margin-top:12px!important}');

$src = JURI::base() . 'media/com_holiness/images/user-' . $this->devotion->userid .'-thumb.' . $this->devotion->imgext;
$date =  new DateTime($this->devotion->ts . '');
$devotion = str_replace("\n", "<br>", $this->devotion->devotion);
$devotionid = JRequest::getVar('id', '', 'get', 'string');

?>

<div class="row-fluid">
    <div class="span3">
      <a href="<?php echo JURI::base() . '#/users/' . $this->devotion->userid; ?>">
      <img src="<?php echo $src; ?>" style="width:150px; height:150px" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" /></a><br>
      <blockquote>
        <p><?php echo '<a href="' . JURI::base() . '#/users/' . $this->devotion->userid . '">' . ucwords(strtolower($this->devotion->name)); ?></a></p>
        <small><?php echo $this->devotion->church; ?></small>
      </blockquote>
    </div>
    <div class="span9">
        <h3 style="margin-top: 0px">Dear friend, hear the voice of the Lord today: <?php echo $this->devotion->scripture; ?></h3>
        <div class="row-fluid" style="margin-top:0px; padding-top: 0px;">
          <div class="span10"><small><?php echo $date->format("l d M Y"); ?></small></div>
          <div class="span2">
            <?php 
            $user =& JFactory::getUser();
            
            if ($user->authorize( 'com_content', 'edit', 'content', 'all' )) { ?>
            <div class="btn-group">
              <button class="btn"><i class="icon-cog"></i></button>
              <button class="btn dropdown-toggle btn-warning" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=devotion.unpublish&id=' . $devotionid); ?>">
                    Unpublish
                  </a>
                </li>
              </ul>
            </div>
            <?php } ?>
          </div>
        </div>
        <blockquote>
          <p><?php echo $this->devotion->reading; ?></p>
          <small><?php echo $this->devotion->scripture; ?> <cite title="Source Title"><?php echo $this->devotion->bible; ?></cite></small>
        </blockquote>
    </div>
</div>
<div class="row-fluid">
  <h3 style="margin-top: 0px"><?php echo $this->devotion->theme; ?></h3>
  <p><strong>Today's devotion:</strong> <?php echo $devotion; ?></p>
  <p><strong>Today's confession / prayer:</strong> <?php echo $this->devotion->prayer; ?></p>
</div>

<script type="text/html" id="comment-tpl">
  <div class="span1">
    <a href="#/users/<%= id %>"><img src="media/com_holiness/images/user-<%= id %>-icon.<%= imgext %>" class="img-circle" onerror="this.src=\'data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==\'" /></a>
  </div>
  
  <div class="span11">
    <strong><a href="#/users/<%= id %>"><%= name %></a></strong>
    <span class="badge badge-info" style="margin-left:10px;">
      <a style="color: #fff;" class="amen-plus" href="#">Amen</a>
    </span>
    <br>
    <small><%= ts %></small>
    <br>
    <%= comment %>
  </div>
</script>

<hr />

<div id="timeline" class="row-fluid">
  <div class="devotion-comments" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 10px 10px 10px;">
  
    <div class="row-fluid">
      <div class="span1" style="margin: 0px; padding: 0px">
        <img src="<?php echo JURI::base() . 'media/com_holiness/images/user-' . $this->profile->userid .'-icon.' . $this->profile->imgext; ?>" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" />
      </div>
      <div class="span11">
        <div class="row-fluid">
          <form style="margin-bottom: 0px; text-align:right">
            <textarea rows="2" cols="10" class="span12" placeholder="Write a comment..."></textarea>
            <button style="padding-right: 20px; padding-left: 20px;" class="btn btn-primary" type="button">Comment</button>
          </form>          
        </div>
      </div>
    </div>

     <div class="row-fluid" id="commentscontainer">
     </div>
  </div>
</div>


<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/devotion.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        $.getComments(<?php echo "'" . JURI::base() . "', " . "'" . $devotionid . "'"; ?>);
    });
}(jQuery));
</script>  

