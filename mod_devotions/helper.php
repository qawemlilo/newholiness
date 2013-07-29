<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModDevotionsHelper
{
    public function getDevotions()
	{   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id, theme FROM #__devotions WHERE published=1 ORDER BY RAND() LIMIT 40";
        $db->setQuery($query); 

		$result = $db->loadObjectList();
        
        return $result;
    }
}