<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

$user =& JFactory::getUser();

if ($user->guest) {
 return;
}

class HolinessViewUser extends JView
{
    function display($tpl = null) {
        parent::display($tpl);
    }
}
