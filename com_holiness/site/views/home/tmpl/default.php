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
  
  .popover {
    width: 250px!important;
  }
  #commentscontainer .comment {margin-top:12px!important} .popover {width: 250px!important;}
  
  div.postbox-cont, #commentscontainer {background: #fff;}
  
  #postbox {background-color: #fff; border: 1px solid #E5E5E5; padding: 10px 20px 10px 20px;}
  
  #user-post, #user-content {padding:20px; background: #fff;}
  
  #commentscontainer {background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 10px 10px 10px;}
');


$HolinessPage = json_encode($this->globvars);
$timelime = json_encode($this->timelime);
$members = json_encode($this->members);

$script = "
(function(window) {
 window.HolinessPageVars = {$HolinessPage};
 window.hp_timelime = {$timelime};
 window.hp_members = {$members};
})(window);
";
$doc->addScriptDeclaration($script);

?>

<div id="app-container" class="row-fluid">
</div>


