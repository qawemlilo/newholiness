<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<div class="row-fluid">
    <form class="form-horizontal well"  id="upload" name="upload" method="post" action="index.php?option=com_holiness&task=user.createprofile" enctype="multipart/form-data">
      <fieldset>
        <legend>Please complete your profile</legend>
        
        <div class="control-group">
          <label class="control-label" for="church"><strong>Goes to:</strong></label>
          <div class="controls">
            <input id="church" name="church" placeholder="Name of your church..." class="span8" required="" type="text">
            <p class="help-block">Church / Ministry</p>
          </div>
        </div>
        
        <div class="control-group">
          <label class="control-label" for="photo"><strong>Picture:</strong></label>
          <div class="controls">
            <input id="photo" name="photo" class="input-file" type="file">
          </div>
        </div>
        
        <div class="control-group" style="margin-bottom: 5px">
          <label class="control-label" for="submit"></label>
          <div class="controls">
            <div class="progress-div span8">
            </div>
          </div>
        </div>
        
        <div class="control-group successful" style="display: none">
          <label class="control-label" for="submit"></label>
          <div class="controls">
            <a href="<?php echo JURI::base(); ?>" class="btn btn-success btn-large" name="submit" id="submit">Profile complete! Proceed</a>
          </div>
        </div>
      </fieldset>
    </form>
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/uploader/script.min.js'; ?>"></script>