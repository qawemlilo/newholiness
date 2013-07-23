<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$style = '.nav [class^="icon-"], .nav [class*=" icon-"] {
  line-height: 1.2em!important;
}';
$document->addStyleDeclaration($style);

?>

<div class="row-fluid">
  <ul class="latestnews nav" style="margin-left: 0px;">
    <?php
        $lists = '';
        
        if(is_array($devotions) && count($devotions) > 0 ) {
            foreach ($devotions as $devotion) {
                $lists .= '<li><a href="' . JURI::base() . '?option=com_holiness&view=devotion&id=' . $devotion->id . '">'; 
                $lists .= '<i class="icon-file icons-left"></i> ' .$devotion->theme . '</a></li>';
            }
            
            echo $lists;
        }
    ?>
  </ul>
</div>