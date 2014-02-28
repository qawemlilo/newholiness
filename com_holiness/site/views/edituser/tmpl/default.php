<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
<form class="form-horizontal well" method="post" action="<?php echo JURI::base()?>index.php?option=com_holiness&task=user.updateuser">
<fieldset>

<legend>Edit Details</legend>

<div class="control-group">
  <label class="control-label" for="theme">Name</label>
  <div class="controls">
    <input id="fullname" name="fullname" value="<?php echo $this->user->name; ?>" class="input-xlarge" type="text">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="bible">Email</label>
  <div class="controls">
    <input id="email" name="email" value="<?php echo $this->user->email; ?>" class="input-xlarge" type="text">
    
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="bible">Church</label>
  <div class="controls">
    <input id="church" name="church" value="<?php echo $this->user->church; ?>" class="input-xlarge" type="text">
    
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="bible">Current Password </label>
  <div class="controls">
    <input id="currentpassword" name="currentpassword"  class="input-xlarge" type="password">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="bible">New Password</label>
  <div class="controls">
    <input id="newpassword" name="newpassword" class="input-xlarge" type="password">
  </div>
</div>

<div class="control-group">
  <label class="control-label" for="button1id"></label>
  <div class="controls">
    <input type="hidden" name="id" value="<?php echo $this->user->id; ?>" />
    <input type="hidden" name="memberid" value="<?php echo $this->user->memberid; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    <button id="button1id" name="button1id" class="btn btn-success" type="submit">Submit</button>
    <a id="button2id" name="button2id" class="btn btn-default" href="javascript:history.go(-1); return false;">Cancel</a>
  </div>
</div>

</fieldset>
</form>
    
  </div>
</div>
