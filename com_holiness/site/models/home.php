<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'timeline.php');


class HolinessModelHome extends JModelItem
{
    public function getTable($type = 'Timeline', $prefix = 'HolinessTable', $config = array()) {
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
                
            return $table;
        }
        
        return false;
    }
    
    
    
    public function update($id, $arr) {
        $table = $this->getTable();
        
        if (!$table->load($id)) {
            return false;
        }
        
        if (!$table->bind($arr)) {
            return false;
        }
        
        if (!$table->store($arr)) {
            return false;
        }
                
        return true;
    }




    public function remove($id) {
        $table =& $this->getTable();

        if (!$table->delete($id)) {
            return false;
        }
                
        return true;
    } 

    
    

    public function getTimeline()
	{   
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        $id = $user->id;
        
        $query = "SELECT timeline.id, timeline.userid, members.imgext, users.name, timeline.userid, timeline.post_type AS posttype, timeline.post, timeline.ts ";
        $query .= "FROM #__hp_timeline AS timeline ";
        $query .= "LEFT OUTER JOIN #__devotion_partners AS partners ";
        $query .= "ON partners.userid = timeline.userid ";
        $query .= "INNER JOIN #__users AS users ";
        $query .= "ON timeline.userid = users.id ";
        $query .= "INNER JOIN #__hpmembers AS members ";
        $query .= "ON timeline.userid = members.userid ";
        $query .= "WHERE timeline.userid=$id OR partners.partnerid=timeline.userid ";
        $query .= "ORDER BY ts";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }    
}

