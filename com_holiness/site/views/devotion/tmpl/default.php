<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('#commentscontainer .comment {margin-top:12px!important} .popover {width: 250px!important;}');

$src = JURI::base() . 'media/com_holiness/images/user-' . $this->devotion->userid .'-thumb.' . $this->devotion->imgext;
$date =  new DateTime($this->devotion->ts . '');
$devotion = str_replace("\n", "<br>", $this->devotion->devotion);
$devotionid = JRequest::getVar('id', '', 'get', 'int');
$currentUser =& JFactory::getUser();


$HolinessPage = json_encode($this->globvars);

$script = "
(function(window) {
    window.HolinessPageVars = {$HolinessPage};
})(window);
";
$doc->addScriptDeclaration($script);

?>

<div style="padding:20px; background-color:#fff;">
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
        <h3 style="margin-top: 0px"><?php echo ucwords($this->devotion->theme); ?></h3>
        <div class="row-fluid" style="margin-top:0px; padding-top: 0px;">
          <div class="span6"><small><?php echo $date->format("l d M Y"); ?></small></div>
          <div class="span6">
            <a class="btn btn-warning pull-right" href="<?php echo JURI::base() ; ?>index.php?option=com_holiness&view=devotion&layout=new"><i class="icon-edit"></i> Share a new Devotion</a>
            <?php 
            $user =& JFactory::getUser();
            
            if ($this->devotion->memberid == $this->profile->id) { ?>
            <div class="btn-group">
              <button class="btn"><i class="icon-cog"></i></button>
              <button class="btn dropdown-toggle btn-warning" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
                <li>
                  <a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&view=devotion&layout=edit&id=' . $devotionid); ?>">
                    Edit
                  </a>
                </li>
                <li>
                  <a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=devotion.unpublish&id=' . $devotionid); ?>">
                    Delete
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
    <p><strong style="color:#0094CB">Today's devotion:</strong> <?php echo $devotion; ?></p>
    <p><strong style="color:#0094CB">Today's confession / prayer:</strong> <?php echo $this->devotion->prayer; ?></p>
  </div>



  <div id="timeline" class="row-fluid" style="margin-top:20px">
   <div id="devotioncommentbox" class="devotion-comments" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 10px 10px 10px;">
    <div class="row-fluid">
      <div class="span1" style="margin: 0px; padding: 0px">
        <img src="<?php echo JURI::base() . 'media/com_holiness/images/user-' . $this->profile->userid .'-icon.' . $this->profile->imgext; ?>" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" />
      </div>
      <div class="span11">
        <div class="row-fluid">
          <form style="margin-bottom: 0px; text-align:right" id="submitcomment" name="submitcomment" action="index.php" method="post">
            <div class="row-fluid">
              <textarea rows="2" cols="10" class="span12" name="txt" id="commentsbox" placeholder="Write a comment..."></textarea>
            </div>
            <div class="row-fluid">
              <div class="span6" style="text-align:left">
                 <strong>Characters: <span id="chars">150</span></strong>
              </div>
              
              <input type="hidden" id="devotionid" name="postid" value="<?php echo $devotionid; ?>" />
              <input type="hidden" name="userid" value="<?php echo $currentUser->id; ?>" />
              <input type="hidden" name="name" value="<?php echo $currentUser->name; ?>" />
              <input type="hidden" name="post_type" value="devotion" />
              
              <div class="span6" style="text-align:right">
                <button style="padding-right: 20px; padding-left: 20px;" class="btn btn-primary" type="submit">Comment</button>
              </div>
            </div>
          </form>       
        </div>
      </div>
    </div>

     <div class="row-fluid" id="commentscontainer">
     </div>
   </div>
  </div>
</div>
