<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hpsearch/assets/css/typeahead.js-bootstrap.css');
$document->addStyleDeclaration(
'input, textarea, .uneditable-input {
  width: 400px;
}');
?>

<div class="row-fluid affix" style="padding: 10px 0px 10px 0px; background-color: #0094cb; border-bottom: 1px solid #E5E5E5; box-shadow: 1px 0px 5px #333; z-index:9999">
  <div class="row-fluid" id="toppannel">
    <form style="margin-bottom:0px" class="pull-left">
      <a href="<?php echo JURI::base(); ?>#">
        <img src="<?php echo JURI::base(); ?>templates/js_wright/images/logo-raw.png" style="width: 192px; margin: 2px 10px 0px 25px">
      </a>
      <input id="search" name="search" placeholder="Search for your Christian friends" type="text" >
    </form>
    
    <ul class="topNav nav nav-pills pull-left" id="mainNavigation" style="margin-left: 50px; margin-bottom: 0px">
       <li>
         <a href="#" title="" id="requestnotices" class="ddowns" data-content="No requests" data-placement="bottom" data-toggle="popover" data-original-title="Devotion Partner Requests">
           <i class="icon-user icon-large"></i> 
           <span class="badge badge-important noti-indicator">1</span>
         </a>
       </li>
       <li>
         <a href="#" title="" id="notifications" class="ddowns" data-content="No notifications" data-placement="bottom" data-toggle="popover" data-original-title="Notifications">
          <i class="icon-flag icon-large"></i> 
          <span class="badge badge-important noti-indicator">1</span>
        </a>
      </li>
       <li><a href="#">Home</a></li>
       <li>
       <div class="btn-group pull-left" style="padding-top: 3px; margin-left: 10px">
         <img title="<?php echo $user->name; ?>" style="width:28px; height: 28px" alt="<?php echo $user->name; ?>" <?php echo $src; ?> />

         <a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
         <ul class="dropdown-menu">
          <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>"><span style="color: #0094CB; margin-right: 10px;"><i class="icon-user"></i></span> My Profile</a></li>
          <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>/edit"><span style="color: #0094CB; margin-right: 10px;"><i class="icon-pencil"></i></span> Edit Account</a></li>
          <li class="divider"></li>
          <li><a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=user.logout'); ?>"><span style="color: #0094CB; margin-right: 10px;"><i class="icon-lock"></i></span> Logout</a></li>
         </ul>
       </div>
       </li>
    </ul>
  </div>
</div>
