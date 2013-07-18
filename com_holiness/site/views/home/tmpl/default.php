<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();

if ($user->guest) {
    return;
}
?>
<div id="timeline" class="row-fluid">
  <div class="timeline-item" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 20px;">
    <div class="row-fluid">
      <div class="span3">
        <div class="row-fluid"><span style="color: blue;"><i class="icon-book"></i></span> Prayer Request</div>
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
  </div>
  
</div>
