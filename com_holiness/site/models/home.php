<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'timeline.php');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'partners.php');


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
        $user =& JFactory::getUser();
        
        if (!$table->load($id)) {
            return false;
        }
        
        if ($table->userid != $user->id) {
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
        $user =& JFactory::getUser();
        
        if (!$table->load($id)) {
            return false;
        }
        
        if ($table->userid != $user->id) {
            return false;
        }

        if (!$table->delete($id)) {
            return false;
        }
                
        return true;
    }
    
    
    function getParners()
    {
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT member.id AS memberid, member.church, member.imgext, user.id, user.name AS value ";
        $query .= "FROM #__hpmembers AS member  ";
        $query .= "INNER JOIN #__devotion_partners AS partner ON partner.partnerid = member.userid ";
        $query .= "INNER JOIN #__users AS user ON member.userid = user.id ";
        $query .= "WHERE partner.userid = $user->id AND partner.active = 1";
        
        $db->setQuery($query); 

        $data = $db->loadObjectList();

        return $data;
    }
    
    
    public function getMe()
    {   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT user.id, user.name, user.email, user.username, member.imgext ";
        $query .= "FROM #__users AS user ";
        $query .= "INNER JOIN #__hpmembers AS member ";
        $query .= "ON user.id=member.userid ";
        $query .= "WHERE user.id={$user->id}";
        
        $db->setQuery($query); 

        $result = $db->loadObject();
        
        return $result;
    } 
    
    


    
    
    function updatePartner($id, $arr) {
        $table = $this->getTable('Partners');
        
        if (!$table->load($id)) {
            return false;
        }
        
        if (is_array($arr) && count($arr) > 0) {
            if (!$table->bind($arr)) {
                return false;
            }
            if (!$table->store($arr)) {
                return false;
            }
                
            return $table;
        }
        
        return false;
    }




    public function removePartner($id) {
        $table = $this->getTable('Partners');
        
        if (!$table->load($id)) {
            return false;
        }
        
        if (!$table->delete($id)) {
            return false;
        }
                
        return true;
    } 
    
    

    
    
    function addPartner($arr) {
        $table = $this->getTable('Partners');
        
        if (is_array($arr) && count($arr) > 0) {
            if (!$table->bind($arr)) {
                return false;
            }
            if (!$table->store($arr)) {
                return false;
            }
                
            return $table;
        }
        
        return false;
    }

    
    

    public function getTimeline($start = 0, $limit = 10) {   
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        $id = $user->id;
        
        $query = "SELECT timeline.id, timeline.userid, members.imgext, members.id AS memberid, users.name, timeline.post_type AS posttype, timeline.post, UNIX_TIMESTAMP(timeline.ts) AS ts ";
        $query .= "FROM #__hp_timeline AS timeline ";
        $query .= "INNER JOIN #__users AS users ";
        $query .= "ON timeline.userid = users.id ";
        $query .= "INNER JOIN #__hpmembers AS members ";
        $query .= "ON timeline.userid = members.userid ";
        $query .= "WHERE timeline.userid=$id OR timeline.userid IN (SELECT partnerid FROM #__devotion_partners AS partners WHERE partners.userid=$id AND partners.active=1) ";
        $query .= "ORDER BY ts DESC";

        $db->setQuery($query, $start, $limit);
        $result = $db->loadObjectList();
        
        return $result;
    }

    
    

    public function getPosts() {   
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        $id = $user->id;
        $start = 0; 
        $limit = 10;
        
        $query = "SELECT timeline.id, timeline.userid, members.imgext, members.id AS memberid, users.name, timeline.post_type AS posttype, timeline.post, UNIX_TIMESTAMP(timeline.ts) AS ts ";
        $query .= "FROM #__hp_timeline AS timeline ";
        $query .= "INNER JOIN #__users AS users ";
        $query .= "ON timeline.userid = users.id ";
        $query .= "INNER JOIN #__hpmembers AS members ";
        $query .= "ON timeline.userid = members.userid ";
        $query .= "WHERE timeline.userid=$id OR timeline.userid IN (SELECT partnerid FROM #__devotion_partners AS partners WHERE partners.userid=$id AND partners.active=1) ";
        $query .= "ORDER BY ts DESC";

        $db->setQuery($query, $start, $limit);
        $result = $db->loadAssocList();
        
        return $result;
    }
    
    
    public function getMembers() {   
        $db = JFactory::getDBO();
        
        $query = "SELECT member.id AS memberid, member.church, member.imgext, user.id, user.name AS value ";
        $query .= "FROM #__hpmembers AS member ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $db->setQuery($query); 

        $result = $db->loadAssocList();
        
        return $result;
    }   
}

