<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'devotion.php');


class HolinessModelDevotion extends JModelItem
{
    public function getTable($type = 'Devotion', $prefix = 'HolinessTable', $config = array()) {
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
    
    
    public function getDevotion()
	{
        $id = JRequest::getVar('id', 0, 'get', 'int');
        $db =& JFactory::getDBO();
        $query = $db->getQuery(true);
        
        $query = "SELECT devotions.*, members.userid, members.church, members.imgext, users.name, users.email ";
        $query .= "FROM #__devotions AS devotions ";
        $query .= "INNER JOIN #__hpmembers AS members ";
        $query .= "ON devotions.memberid=members.id ";
        $query .= "INNER JOIN #__users AS users ";
        $query .= "ON members.userid=users.id ";
        $query .= "WHERE  devotions.id={$id}";
        
        $db->setQuery($query);
        $result = $db->loadObject();
        
        return $result;
    }
}

