<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

?>

<div class="row-fluid affix" style="padding: 15px 0px 10px 0px; background-color: #F1F1F1; border-bottom: 1px solid #E5E5E5;">
  <div class="span7">
    <div class="row-fluid">
      <div class="input-append">
        <img src="<?php echo JURI::base(); ?>templates/js_wright/images/logo-raw.png" style="width: 192px; margin: 2px 10px 0px 10px">
        <input class="span6" id="search" name="search" placeholder="Search for your Christian friends" type="text" >
        <button class="btn" type="button">Search</button>
      </div>
    </div>
  </div>
  
  <div class="span5">
    <div class="btn-group pull-right" style="margin-right: 10px">
      <img title="<?php echo $user->name; ?>" style="width:38px" alt="<?php echo $user->name; ?>" src="<?php echo $src; ?>" />

      <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>"><i class="icon-user"></i> My Profile</a></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>/edit"><i class="icon-pencil"></i> Edit Account</a></li>
         <li class="divider"></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=user.logout'); ?>"><i class="icon-lock"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript">
(function ($) {
  $(function () {
    $('input#search').typeahead({
      source: ['tim trueman', 'Jake Harding', 'vskarich']
    });
  });
}(jQuery))
</script>