<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$doc =& JFactory::getDocument();
$HolinessPage = json_encode($this->globvars);

$script = "
(function(window) {
    window.HolinessPageVars = {$HolinessPage};
})(window);
";
$doc->addScriptDeclaration($script);

?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
<form class="form-horizontal well">
<fieldset>

<!-- Form Name -->
<legend>New Devotion</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="theme">Today's theme</label>
  <div class="controls">
    <input id="theme" name="theme" placeholder="Today's theme" class="input-xlarge" type="text">
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="scripture">Today's scripture</label>
  <div class="controls">
    <select id="scripture" name="scripture" class="input-xlarge">
      <option>Option one</option>
      <option>Option two</option>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for=" "></label>
  <div class="controls">
    <select id=" " name=" " class="input-small">
      <option>Option one</option>
      <option>Option two</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="scripture">The scripture reads as follows</label>
  <div class="controls">                     
    <textarea id="scripture" name="scripture"></textarea>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bible">Bible translation used</label>
  <div class="controls">
    <input id="bible" name="bible" placeholder="Bible translation used" class="input-xlarge" type="text">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="devotion">Today's devotion</label>
  <div class="controls">                     
    <textarea id="devotion" name="devotion"></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="prayer">Today's confession / prayer</label>
  <div class="controls">                     
    <textarea id="prayer" name="prayer"></textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="button1id"></label>
  <div class="controls">
    <button id="button1id" name="button1id" class="btn btn-success">Submit</button>
    <button id="button2id" name="button2id" class="btn btn-default">Cancel</button>
  </div>
</div>

</fieldset>
</form>
    
  </div>
</div>
