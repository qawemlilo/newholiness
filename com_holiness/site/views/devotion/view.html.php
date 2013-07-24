<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewDevotion extends JView
{
    function display($tpl = null) {
        $this->devotion = $this->get('Devotion');
        
        print_r($this->devotion);
        exit();
        
        parent::display($tpl);
    }
}
