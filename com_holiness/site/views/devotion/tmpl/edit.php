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

$books = array("Genesis", "Exodus", "Leviticus", "Numbers", "Deuteronomy", "Joshua", "Judges", "Ruth", "1 Samuel", "2 Samuel", "1 Kings", "2 Kings", "1 Chronicles", "2 Chronicles", "Ezra", "Nehemiah", "Esther", "Job", "Psalms", "Proverbs", "Ecclesiastes", "Song of Solomon (Song of Songs)", "Isaiah", "Jeremiah", "Lamentations", "Ezekiel", "Daniel", "Hosea", "Joel", "Amos", "Obadiah", "Jonah", "Micah", "Nahum", "Habakkuk", "Zephaniah", "Haggai", "Zechariah", "Malachi", "Matthew", "Mark", "Luke", "John", "Acts", "Romans", "1 Corinthians", "2 Corinthians", "Galatians", "Ephesians", "Philippians", "Colossians", "1 Thessalonians", "2 Thessalonians", "1 Timothy", "2 Timothy", "Titus", "Philemon", "Hebrews", "James", "1 Peter", "2 Peter", "1 John", "2 John", "3 John", "Jude", "Revelation");

$biblebook = substr($this->devotion->scripture, 0, strrpos($this->devotion->scripture, ' '));
$chapterandverse = substr(strrchr($this->devotion->scripture, ' '), 1);
$chapterandverse = explode(':', $chapterandverse);
$mychapter = $chapterandverse[0];
$myverse = $chapterandverse[1];
?>

<div style="padding:20px; background-color:#fff;">
  <div class="row-fluid">
<form class="form-horizontal well" method="post" action="<?php echo JURI::base()?>index.php?option=com_holiness&task=devotion.edit">
<fieldset>

<!-- Form Name -->
<legend>New Devotion</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="theme">Today's theme</label>
  <div class="controls">
    <input id="theme" name="theme" placeholder="Today's theme" class="input-xlarge" type="text" value="<?php echo $this->devotion->theme; ?>">
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for="scripture">Today's scripture</label>
  <div class="controls">
    <select id="book" name="book">
    <?php 
    $opts = '';
      foreach($books as $book){
          if ($book == $biblebook) {
              $opts .= '<option selected="selected" value="' . $book . '">' . $book . '</option>';   
          }
          else {
              $opts .= '<option value="' . $book . '">' . $book . '</option>';
          }
      }
    
      echo $opts; 
    ?>
    </select>
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label" for=" "></label>
  <div class="controls">
    Chapter
    <select id="chapter" name="chapter" class="input-small">
    <?php 
      $opts2 = '';
      for($i = 1; $i < 151; $i++) {
          if ((int)$mychapter == $i) {
              $opts2 .= '<option selected="selected" value="' . $i . '">' . $i . '</option>';
          }
          else {
              $opts2 .= '<option value="' . $i . '">' . $i . '</option>';
          }
      }
    
      echo $opts2; 
    ?>
    </select>
    
    Verse
    <select id="verse" name="verse" class="input-small"> 
    <?php 
      $opts3 = '';
      for($i2 = 1; $i2 < 177; $i2++) {
          if ((int)$myverse == $i2) {
              $opts3 .= '<option selected="selected" value="' . $i2 . '">' . $i2 . '</option>';
          }
          else {
              $opts3 .= '<option value="' . $i2 . '">' . $i2 . '</option>';
          }
      }
    
      echo $opts3; 
    ?>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="reading">The scripture reads as follows</label>
  <div class="controls">                     
    <textarea id="reading" name="reading" rows="5"><?php echo $this->devotion->reading; ?></textarea>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="bible">Bible translation used</label>
  <div class="controls">
    <input id="bible" name="bible" placeholder="Bible translation used" class="input-xlarge" type="text" value="<?php echo $this->devotion->bible; ?>">
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="devotion">Today's devotion</label>
  <div class="controls">                     
    <textarea id="devotion" name="devotion" rows="5"><?php echo $this->devotion->devotion; ?></textarea>
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label" for="prayer">Today's confession / prayer</label>
  <div class="controls">                     
    <textarea id="prayer" name="prayer" rows="5"><?php echo $this->devotion->prayer; ?></textarea>
  </div>
</div>

<!-- Button (Double) -->
<div class="control-group">
  <label class="control-label" for="button1id"></label>
  <div class="controls">
    <input type="hidden" name="memberid" value="<?php echo $this->devotion->memberid; ?>" />
    <input type="hidden" name="devotionid" value="<?php echo $this->devotion->id; ?>" />
    <input type="hidden" value="<?php echo $mbook; ?>" />
    <input type="hidden" value="<?php echo $verse; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
    <button id="button1id" name="button1id" class="btn btn-success" type="submit">Update</button>
    <a id="button2id" name="button2id" class="btn btn-default" href="javascript:history.go(-1); return false;">Cancel</a>
  </div>
</div>

</fieldset>
</form>
    
  </div>
</div>
