<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();
?>
<div class="row-fluid">
    <form class="form-horizontal"  id="upload" name="upload" method="post" action="index.php?option=com_holiness&task=user.createprofile" enctype="multipart/form-data" style="border: 5px solid #E5E5E5">
      <fieldset>
        <legend style="width:98%; padding-left: 2%; border-bottom-width: 2px; line-height: normal; padding-top: 10px; padding-bottom: 10px; color:#0094CB">Please complete your profile</legend>

        <div class="control-group">
          <label style="width:100px;" class="control-label" for=""><strong>Name:</strong></label>
          <div style="margin-left:120px;" class="controls">
            <input id="" name="" value="<?php echo $user->name; ?>" class="span8" type="text" readonly="readonly" >
          </div>
        </div>
        
        <div class="control-group">
          <label style="width:100px;" class="control-label" for=""><strong>Email:</strong></label>
          <div style="margin-left:120px;" class="controls">
            <input id="" name="" value="<?php echo $user->email; ?>" class="span8" type="text" readonly="readonly" >
          </div>
        </div>
        
        <div class="control-group">
          <label style="width:100px;" class="control-label" for="church"><strong>Goes to:</strong></label>
          <div style="margin-left:120px;" class="controls">
            <input id="church" name="church" placeholder="Name of your church..." class="span8" required="" type="text">
            <p class="help-block">Church / Ministry</p>
          </div>
        </div>
        
        <div class="control-group">
          <label style="width:100px;" class="control-label" for="photo"><strong>Picture:</strong></label>
          <div style="margin-left:120px;" class="controls">
            <input id="photo" name="photo" class="input-file" type="file">
          </div>
        </div>
        
        <div class="control-group progress-cont" style="margin-bottom: 5px; display: none">
          <label style="width:100px;" class="control-label" for=""></label>
          <div style="margin-left:120px;" class="controls">
            <div class="progress-div span8">
            </div>
          </div>
        </div>
        
        <div class="control-group successful" style="display: none">
          <label style="width:100px;" class="control-label" for=""></label>
          <div style="margin-left:120px;" class="controls">
            <a href="<?php echo JURI::base(); ?>" class="btn btn-success btn-large" name="submit" id="submit"><i class="icon-ok icon-white"></i> Profile complete! Proceed</a>
          </div>
        </div>
      </fieldset>
    </form>
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/uploader/script.min4.js'; ?>"></script>