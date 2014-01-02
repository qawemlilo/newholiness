<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewHome extends JView
{
    function display($tpl = null) {
        $this->globvars = $this->getGlobalVars();
        parent::display($tpl);
    }
    
    
    function getGlobalVars() {
        $user = $this->get('Me');
        $partners = $this->get('Parners');
        
        $data = array(
            'id'=>$user->id,
            'name'=>$user->name,
            'username'=>$user->username,
            'baseUrl'=>JURI::base(),
            'email'=>$user->email,
            'imgext'=>$user->imgext,
            'partners'=>$partners
        ); 

        return $data;        
    }
}
