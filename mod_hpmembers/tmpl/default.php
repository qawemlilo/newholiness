<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 
/*
$document =& JFactory::getDocument();
$style = '.nav [class^="icon-"], .nav [class*=" icon-"] {
  line-height: 1.2em!important;
}';
$document->addStyleDeclaration($style);
*/
?>

<div class="row-fluid members-container">
  <ul class="unstyled" id="members-list">
  </ul>
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/underscore-min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'components/com_holiness/assets/js/backbone.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpmembers/assets/js/script.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        $.getUsers();
    });
}(jQuery));
</script>  

