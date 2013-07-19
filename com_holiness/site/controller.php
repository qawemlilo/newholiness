<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
class HolinessController extends JController
{
	function display() {
        $application =& JFactory::getApplication();
        $user =& JFactory::getUser();
        $model =& $this->getModel('user');
        
        $hack = JRequest::getVar('hk', 0, 'get', 'int');
        $view = JRequest::getVar('view');
        $homepage = JURI::base();
        
        $hasProfile = $model->hasProfile();
        
        // if the user is registered and does not have a profile
        // take them to the profile competion page
        if (!$hasProfile && !$hack && !$user->guest) {
            $application->redirect('index.php?option=com_holiness&view=user&hk=1');
        }
        
        // if the user is not logged in, show them the registration/login page.
        elseif ($user->guest) {
            JRequest::setVar('view', 'user');
            JRequest::setVar('layout', 'register');
        }
                parent::display();    }}
