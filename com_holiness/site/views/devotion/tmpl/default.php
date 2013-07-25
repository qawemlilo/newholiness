<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$src = JURI::base() . 'media/com_holiness/images/user-' . $this->devotion->userid .'-thumb.' . $this->devotion->imgext;
$date =  new DateTime($this->devotion->ts . '');
$devotion = str_replace("\n", "<br>", $this->devotion->devotion);
?>

<div class="row-fluid">
    <div class="span3">
      <a href="<?php echo JURI::base() . '#/users/' . $this->devotion->userid; ?>">
      <img src="<?php echo $src; ?>" style="width:150px; height:150px" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" /></a><br>
      <blockquote>
        <p><?php echo '<a href="' . JURI::base() . '#/users/' . $this->devotion->userid . '">' . $this->devotion->name; ?></a></p>
        <small><?php echo $this->devotion->church; ?></small>
      </blockquote>
    </div>
    <div class="span9">
        <h3 style="margin-top: 0px">Dear friend, hear the voice of the Lord today: <?php echo $this->devotion->scripture; ?></h3>
        <p style="margin-top:0px; padding-top: 0px;"><small><?php echo $date->format("l d M Y"); ?></small></p>

        <blockquote>
          <p><?php echo $this->devotion->reading; ?></p>
          <small><?php echo $this->devotion->scripture; ?> <cite title="Source Title"><?php echo $this->devotion->bible; ?></cite></small>
        </blockquote>
    </div>
</div>
<div class="row-fluid">
  <h3 style="margin-top: 0px"><?php echo $this->devotion->theme; ?></h3>
  <p><strong>Today's devotion:</strong> <?php echo $devotion; ?></p>
  <p><strong>Today's confession / prayer:</strong> <?php echo $this->devotion->prayer; ?></p>
</div>

<div id="timeline" class="row-fluid">
  <div class="devotion-comments" style="background-color: #F1F1F1; border: 1px solid #E5E5E5; padding: 10px 10px 10px 10px;">
    <div class="row-fluid">
      <div class="span1">
        <img src="<?php echo JURI::base() . 'media/com_holiness/images/user-' . $this->profile->userid .'-icon.' . $this->profile->imgext; ?>" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" style="margin-top:5px" class="img-circle" />
      </div>
      <div class="span11">
        <div class="row-fluid">
          <form style="margin-bottom: 0px;">
            <textarea rows="2" cols="10" class="span12" placeholder="Write a comment..."></textarea>
          </form>          
        </div>
        <div class="row-fluid" style="text-align:right">
          <button style="padding-right: 20px; padding-left: 20px;" class="btn btn-primary" type="button">Comment</button>
        </div>
      </div>
    </div>
  </div>
</div>
  

