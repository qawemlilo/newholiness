<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModRecentDevotionsHelper
{
    /**
     * Returns a list of post items
    */
    private $results = null;
    
    public function getDevotions($limit, $pid)
    {
        if (!$this->results) {
		    $db =& JFactory::getDBO();       
        
            if ($pid) {
                $query = "SELECT * FROM #__devotions WHERE pastor='$pid' ORDER BY ts DESC";   
            } else {
                 $query = "SELECT * FROM #__devotions ORDER BY ts DESC";          
            }
        
            $db->setQuery($query, 0, $limit); 
        
            $this->results = $db->loadObjectList();
        }

		return $this->results;
    }
}