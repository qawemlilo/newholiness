<?php 
defined('_JEXEC') or die('Restricted access'); // no direct access 

$document =& JFactory::getDocument();
$style = '.nav [class^="icon-"], .nav [class*=" icon-"] {
  line-height: 1.2em!important;
}';
$document->addStyleDeclaration($style);

?>

<div class="row-fluid">
  <ul class="latestnews nav" style="margin-left: 10px;">
	<li>
      <a href="/holliness/index.php/how-does-it-work"><i class="icon-file icons-left"></i> How does it work?</a>
	</li>
    <li>
      <a href="/holliness/index.php/learn-more"><i class="icon-file icons-left"></i>Learn More </a>
    </li>
  </ul>
</div>