<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewHome extends JView
{
    function display($tpl = null) {
        $application =& JFactory::getApplication();
        $model =& $this->getModel();
        $hack = JRequest::getVar('hk', 0, 'get', 'int');
        
        if (!$model->hasProfile() && !$hack) {
            $application->redirect('index.php?option=com_holiness&view=user&hk=1');
        }
        
        parent::display($tpl);
    }
}
