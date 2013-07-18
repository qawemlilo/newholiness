<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'user.php');


class HolinessModelUser extends JModelItem
{
    public function getTable($type = 'User', $prefix = 'HolinessTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    
    
    public function create($arr = array()) {
        
        if (is_array($arr) && count($arr) > 0) {
            $table = $this->getTable();
            
            if (!$table->bind( $arr )) {
                return false;
            }
            if (!$table->store( $arr )) {
                return false;
            }
                
            return $table->id;
        }
        
        return false;
    }
    
    
    
    public function hasProfile()
	{   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id FROM #__hpmembers WHERE userid='$user->id'";
        $db->setQuery($query); 

		return $db->loadResult();
    }
}

