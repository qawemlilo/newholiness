<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
<form class="form-horizontal well" method="post" action="<?php echo JURI::base()?>index.php?option=com_holiness&task=user.updateuser">
<fieldset>

<!-- Form Name -->
<legend>Edit Details</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="theme">Name</label>
  <div class="controls">
    <input id="fullname" name="fullname" value="<?php echo $user->name; ?>" class="input-xlarge" type="text">
  </div>
</div>


<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bible">Email</label>
  <div class="controls">
    <input id="email" name="email" value="<?php echo $user->email; ?>" class="input-xlarge" type="text">
    
  </div>
</div>


<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="button1id"></label>
  <div class="controls">
    <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    <button id="button1id" name="button1id" class="btn btn-success" type="submit">Submit</button>
    <a id="button2id" name="button2id" class="btn btn-default" href="javascript:history.go(-1); return false;">Cancel</a>
  </div>
</div>

</fieldset>
</form>
    
  </div>
</div>
