<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<div class="row-fluid">
<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Please complete your profile</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="church">Goes to</label>
  <div class="controls">
    <input id="church" name="church" placeholder="Name of your church..." class="input-xlarge" required="" type="text">
    <p class="help-block">Church / Ministry</p>
  </div>
</div>

<!-- File Button --> 
<div class="control-group">
  <label class="control-label" for="photo">Picture</label>
  <div class="controls">
    <input id="photo" name="photo" class="input-file" type="file">
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit"></label>
  <div class="controls">
    <button id="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
</form>
</div>