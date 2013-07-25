<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$src = JURI::base() . 'media/com_holiness/images/user-' . $this->devotion->userid .'-thumb.' . $this->devotion->imgext;
$date =  new DateTime($this->devotion->ts . '');
?>

<div class="row-fluid">
    <div class="span3">
      <img src="<?php echo $src; ?>" style="width:150px; height:150px" onerror="this.src='data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='" class="img-polaroid" /><br>
      <blockquote>
        <p><?php echo $this->devotion->name; ?></p>
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
  <p><strong>Today's devotion:</strong> <?php echo $this->devotion->devotion; ?></p>
  <p><strong>Today's confession / prayer:</strong> <?php echo $this->devotion->prayer; ?></p>
</div>
  

