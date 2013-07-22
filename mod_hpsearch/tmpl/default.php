<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hpsearch/assets/css/typeahead.js-bootstrap.css');
$document->addStyleDeclaration(
'input, textarea, .uneditable-input {
  width: 300px;
}');
$document->addScript(JURI::base() . 'modules/mod_hpsearch/assets/js/hogan.min.js');
?>

<div class="row-fluid affix" style="padding: 10px 0px 10px 0px; background-color: #F1F1F1; border-bottom: 1px solid #E5E5E5; box-shadow: 1px 0px 5px #333;">
  <div class="span7">
    <div class="row-fluid">
    <form style="margin-bottom:0px">
      <img src="<?php echo JURI::base(); ?>templates/js_wright/images/logo-raw.png" style="width: 192px; margin: 2px 10px 0px 10px">
      <input id="search" name="search" placeholder="Search for your Christian friends" type="text" >
    </form>
    </div>
  </div>
  
  <div class="span5">
    <div class="btn-group pull-right" style="margin-right: 10px">
      <img title="<?php echo $user->name; ?>" style="width:38px; height: 38px" alt="<?php echo $user->name; ?>" <?php echo $src; ?> />

      <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>"><span style="color: #0094CB"><i class="icon-user"></i></span> My Profile</a></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '#/users/' . $user->id); ?>/edit"><span style="color: red;"><i class="icon-pencil"></i></span> Edit Account</a></li>
         <li class="divider"></li>
        <li><a href="<?php echo JRoute::_(JURI::base() . '?option=com_holiness&task=user.logout'); ?>"><i class="icon-lock"></i> Logout</a></li>
      </ul>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpsearch/assets/js/typeahead.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpsearch/assets/js/script.js'; ?>"></script>