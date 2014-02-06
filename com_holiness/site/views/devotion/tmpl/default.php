<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('
  #commentscontainer .comment {margin-top:12px!important} .popover {width: 250px!important;}
  #commentscontainer {background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 10px 10px 10px;}
  ul.inline > li, ol.inline > li {
    display: inline-block;
    *display: inline;
    padding-right: 5px;
    padding-left: 5px;
    margin-right:25px;
    *zoom: 1;
  }
');

$src = JURI::base() . 'media/com_holiness/images/user-' . $this->devotion->userid .'-thumb.' . $this->devotion->imgext;
$date =  new DateTime($this->devotion->ts . '');
$devotion = str_replace("\n", "<br>", $this->devotion->devotion);
$devotionid = JRequest::getVar('id', '', 'get', 'int');
$currentUser =& JFactory::getUser();


$HolinessPage = json_encode($this->globvars);
$members = json_encode($this->members);

$script = "
(function(window) {
window.HolinessPageVars = {$HolinessPage};
window.hp_members = {$members};
})(window);
";
$doc->addScriptDeclaration($script);

?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
    <div class="span3">
      <a href="<?php echo JURI::base() . '#/users/' . $this->devotion->userid; ?>">
      <img src="<?php echo $src; ?>" style="width:100px; height:100px" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" /></a><br>
      <blockquote>
        <p><?php echo '<a href="' . JURI::base() . '#/users/' . $this->devotion->userid . '">' . ucwords(strtolower($this->devotion->name)); ?></a></p>
        <small><?php echo $this->devotion->church; ?></small>
      </blockquote>
    </div>
    <div class="span9" id="devbuttons">
        <h2 style="margin-top: 0px"><?php echo ucwords($this->devotion->theme); ?></h2>
        <div class="row-fluid" style="margin: 10px 0px 10px 0px; padding-top: 0px;">
          <div class="span3"><small><?php echo $date->format("l d M Y"); ?></small></div>
          <div class="span9">
            <button class="btn btn-primary" id="adddevotionauthor" style="margin-right:10px;">Make Devotion Parther</button>
            
            <a class="btn btn-warning" href="<?php echo JURI::base() ; ?>index.php?option=com_holiness&view=devotion&layout=new"><i class="icon-edit"></i> Share a new Devotion</a>
            <?php 
            
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
  
  <?php
   echo $this->recentDevotions;
  ?>
  
  <div class="row-fluid">
    <p><strong style="color:#0094CB">Today's devotion:</strong> <?php echo $devotion; ?></p>
    <p><strong style="color:#0094CB">Today's confession / prayer:</strong> <?php echo $this->devotion->prayer; ?></p>
  </div>
  
  <div class="row-fluid" style="margin-top: 10px">
    <ul class="inline unstyled">
      <li class="print"><i class="icon-print"></i> <a onclick="javascript: window.print()" href="#">Print this devotion</a></li>
      <li class="download"><i class="icon-download-alt"></i>  <a target="_blank" href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=devotion.download&id=' . $devotionid); ?>">Download this devotion</a></li>
      <li class="email"><i class="icon-envelope"></i> <a href="#myModal" title="Email this devotion to a friend" role="button" data-toggle="modal">Email this devotion</a></li>
    </ul>
  </div>
  
  <!-- Modal hidden form -->
  <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header" style="background-color:#0094cb">
      <h3 id="myModalLabel" style="color:#fff">Email this devotion to a friend</h3>
    </div>
    
    <form class="form-horizontal" id="chgform" method="past" action="index.php?option=com_holiness&task=devotion.emaildevotion">
    <div class="modal-body">
        <div id="progress" class="passprogress progress progress-striped active" style="display:none">
          <div class="bar" style="width: 100%;"></div>
        </div>
        
        <div id="responseD" class="passresponse alert" style="display:none">
        </div> 
    
        <div class="control-group">
          <label class="control-label" for="to_name">Your Friend's Name:</label>
          
          <div class="controls">
            <input id="to_name" type="text" name="to_name" value="" class="input-xlarge">
          </div>
        </div>
    
        <div class="control-group">
          <label class="control-label" for="to_email">Your Friend's email:</label>
          
          <div class="controls">
            <input id="to_email" type="text" name="to_email" value="" class="input-xlarge">
          </div>
        </div>
    
        <div class="control-group">
          <label class="control-label" for="msg">Message:</label>
          
          <div class="controls">
            <textarea class="input-xlarge" rows="5" id="msg" name="msg"><?php echo $this->devotion->theme; ?></textarea>
          </div>
        </div>
        
        <input name="from_name" value="<?php echo $this->user->name; ?>" type="hidden">
        <input name="from_email" value="<?php echo $this->user->email; ?>" type="hidden">
        <input type="hidden" name="theme" value="<?php echo $this->devotion->theme . ": " . $this->devotion->scripture; ?>">
        <input type="hidden" name="url" value="<?php echo JURI::base() . '?option=com_holiness&view=devotion&id=' . $this->devotion->id; ?>">
        
        <?php echo JHtml::_('form.token'); ?>
    </div>
    
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      <button class="btn btn-primary" id="submit">Send</button>
    </div>
     </form>
  </div>
  <!-- ENDOF Modal hidden form -->

  <div id="timeline" class="row-fluid" style="margin-top:20px">   
  </div>
  
  <form>
    <input type="hidden" id="devotionid" name="postid" value="<?php echo $devotionid; ?>" />
    <input type="hidden" id="authorid" name="author" value="<?php echo $this->devotion->userid; ?>" />
  </form>    
</div>
