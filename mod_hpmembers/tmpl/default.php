<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$style = '#members-list li {margin-bottom: 2px; padding-bottom: 2px;}';
$document->addStyleDeclaration($style);
?>

<div class="row-fluid members-container">
  <ul class="unstyled" id="members-list">
  </ul>
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpmembers/assets/js/script.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        var members = $.getUsers();
    });
}(jQuery));
</script>  

