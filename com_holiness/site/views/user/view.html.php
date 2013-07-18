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
        $application =& JFactory::getApplication();
        $model =& $this->getModel();
        
        if ($model->hasProfile()) {
            $application->redirect(JURI::base());
        }
        parent::display($tpl);
    }
}
