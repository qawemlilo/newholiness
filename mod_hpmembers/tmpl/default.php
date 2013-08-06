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


<!------------------------------------------------------- JavaScript Templates  ------------------------------------------>

<script type="text/html" id="member-tpl">
  <div class="row-fluid fellow">
    <div class="span3">
      <img src="media/com_holiness/images/user-<%= id %>-thumb.<%= imgext %>" onerror="this.src='modules/mod_hpmembers/assets/images/none.jpg'" />
    </div>
    
    <div class="span9"><div class="row-fluid">
      <p><strong><a href="#/users/<%= id %>"><%= value %></a></strong><br>
      <small><%= church %></small></p>
      <p><button class="btn add-partner"><small>Make devotion partner</small></button></p>
    </div>
  </div>
</script>

<!------------------------------------------------------- ENDOF; JavaScript Templates  ------------------------------------------>


<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_hpmembers/assets/js/script.js'; ?>"></script>
<script type="text/javascript">
jQuery.noConflict();

(function ($) {
    $(function () {
        var members = $.getUsers();
    });
}(jQuery));
</script>  

