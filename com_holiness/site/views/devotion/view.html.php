<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

class HolinessViewDevotion extends JView
{
    function display($tpl = null) {
        $layout = JRequest::getVar('layout', '', 'get', 'string');
        $id = JRequest::getVar('id', '', 'get', 'string');
        $model = $this->getModel();
        $user = JFactory::getUser();
        
        $me = $model->getMe($user->id);
        $partners = $model->getParners($user->id);
        
        if ($id || !$layout == 'new') {
            $this->devotion = $model->getDevotion($id);
            
            $recentDevotions = $model->getRecentDevotions($this->devotion->memberid);
            $this->recentDevotions = $this->recentDevotions($recentDevotions);            
        }
        
        $this->profile = $model->getProfile($user->id);
        $this->globvars = $this->getGlobalVars($me, $partners);
        
        parent::display($tpl);
    }
    
    
    function getGlobalVars($user, $partners) {
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
    
    
    function recentDevotions ($devotions) {
        $container = '';
        
        if (is_array($devotions) && count($devotions) > 0) {
            $container = '<div class="row-fluid well">';
            $leftside = '<div class="span6"><ul class="unstyled" style="margin-left: 20px">';
            $rightside = '<div class="span6"><ul class="unstyled">';
            $counter = 0;
        
        
            foreach ($devotions as $devotion) {
                $li = '<li>';
                $li .= '<a href="' . JRoute::_( JURI::base() . '?option=com_holiness&view=devotion&id=' . $devotion->id) . '">';
                $li .= '<i class="icon-file icons-left"></i> ' . $devotion->theme;
                $li .= '</a></li>'; 
                
                if ($counter < 5) {
                    $leftside .= $li;
                }
                else {
                    $rightside .= $li;
                }
                
                $counter += 1;          
            }
            
            $leftside .= '</ul></div>';
            $rightside .= '</ul></div>';
            
            $container .= $leftside . $rightside . '</div>';
        }
        
        return $container;        
    }
}
