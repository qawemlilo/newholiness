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

