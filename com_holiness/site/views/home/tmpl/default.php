<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$doc->addStyleDeclaration('
  div.row-fluid a.edit-timeline-item.dropdown-toggle {
      color: #ddd!important;
  }
  
  div.row-fluid a.edit-timeline-item.dropdown-toggle:hover {
      color: #08c!important;
  }
  
  .highlight {
      background: #ffff99!important;
  }
  
  .timelinepost-main-edit {
      display:none;
  }
');


$HolinessPage = json_encode($this->globvars);

$script = "
(function(window) {
    window.HolinessPageVars = $HolinessPage
})(window);
";
$doc->addScriptDeclaration($script);

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

<div id="timeline-content" class="content-display hide">
</div>

<div id="user-content" class="content-display hide" style="padding:20px; background-color:#fff;">
</div>

<div id="user-post" class="content-display hide" style="padding:20px; background-color:#fff;">
</div>


