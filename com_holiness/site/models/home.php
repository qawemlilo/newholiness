<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');


class HolinessModelHome extends JModelItem
{
    public function hasProfile()
	{   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id FROM #__hpmembers WHERE userid='$user->id'";
        $db->setQuery($query); 

		return $db->loadResult();
    }
}

