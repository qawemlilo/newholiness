<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewHome extends JView
{
    function display($tpl = null) {
        $user = $this->get('Me');
        $partners = $this->get('Parners');
        $timelime = $this->get('Posts');
        $members = $this->get('Members');
        
        $this->globvars = $this->getGlobalVars($user, $partners, $timelime);
        $this->timelime = $timelime;
        $this->members = $members;
        
        parent::display($tpl);
    }
    
    
    function getGlobalVars($user, $partners, $timelime) {
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
