<?php
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');
 

// Get an instance of the controller prefixed by Holiness
// it will create a controller named FileManagerController using the controller.php file
$controller = JController::getInstance('Holiness');

 

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

$controller->redirect();
