<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModHPSearchHelper
{
    public function getProfile()
	{   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT imgext, church FROM #__hpmembers WHERE userid='$user->id'";
        $db->setQuery($query); 

		$result = $db->loadObject();
        
        return $result;
    }
}