<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewDevotion extends JView
{
    function display($tpl = null) {
        $this->devotion = $this->get('Devotion');
        $this->profile = $this->get('Profile'); 
        $this->globvars = $this->getGlobalVars();
        
        parent::display($tpl);
    }
    
    
    function getGlobalVars() {
        $user =& JFactory::getUser();
        $partners = $this->get('Parners');
        
        $data = array(
            'id'=>$user->id,
            'name'=>$user->name,
            'username'=>$user->username,
            'baseUrl'=>JURI::base(),
            'email'=>$user->email,
            'partners'=>$partners
        ); 

        return $data;        
    }
}
