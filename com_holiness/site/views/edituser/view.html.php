<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewEdituser extends JView
{
    function display($tpl = null) {
        $this->user = $this->get('Member');

        parent::display($tpl);    
    }
}
