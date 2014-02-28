<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'user.php');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'partners.php');


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
    
    
    
    public function update($id, $arr) {
        $table = $this->getTable();
        $user = JFactory::getUser();
        
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
    
    
    public function getMembers() {   
        $db = JFactory::getDBO();
        
        $query = "SELECT member.id AS memberid, member.church, member.imgext, user.id, user.name AS value ";
        $query .= "FROM #__hpmembers AS member ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $db->setQuery($query); 

       $result = $db->loadObjectList();
        
        return $result;
    }
    
    


    
    public function getMember() {   
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        
        $query = "SELECT member.church, member.imgext, user.id, user.name, user.email ";
        $query .= "FROM #__hpmembers AS member ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $query .= "WHERE member.userid=$user->id";
        
        $db->setQuery($query); 

		$result = $db->loadObjectList();
        
        return $result;
    }

    
    public function getUser($name) {   
        $db = JFactory::getDBO();
        
        $query = "SELECT member.id, member.userid, member.church, member.imgext, user.name ";
        $query .= "FROM #__hpmembers member ";
        $query .= "INNER JOIN #__users user ON member.userid = user.id ";
        $query .= "WHERE user.name LIKE '{$name}%'";
        
        $db->setQuery($query); 

		$result = $db->loadObjectList();
        
        return $result;
    }
    
    
    function addPartner($arr) {
        $userid = (int)$arr['userid'];
        $partnerid = (int)$arr['partnerid'];
        
        if (!$partnerid || !$userid) {
            return false;
        }
        
        $partnerShipId = $this->checkPartner($userid, $partnerid);
        
        if ($partnerShipId && !$arr['active']) {
            return false;
        }
        
        $row = $this->getTable('Partners');
        
        if (!$row->bind($arr)) {
            return false;
        }
        if (!$row->store($arr)) {
            return false;
        }
        
        $result = array ('id'=>$row->id, 'userid'=>$row->userid, 'partnerid'=>$row->partnerid);
                
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
    
    
    function getParners($id) {
        $db = JFactory::getDBO();
        
        $query = "SELECT member.id AS memberid, member.church, member.imgext, user.id, user.name AS value ";
        $query .= "FROM #__hpmembers AS member ";
        $query .= "INNER JOIN #__devotion_partners AS partner ON partner.partnerid = member.userid ";
        $query .= "INNER JOIN #__users AS user ON member.userid = user.id ";
        $query .= "WHERE partner.userid=$id AND partner.active = 1";
        
        $db->setQuery($query); 

        $data = $db->loadObjectList();

        return $data;
    }
    
    
    private function checkPartner($userid, $partnerid) {   
        $db = JFactory::getDBO();
        
        $query = "SELECT partners.id ";
        $query .= "FROM #__devotion_partners AS partners ";
        $query .= "WHERE (partners.userid={$userid} AND partners.partnerid={$partnerid}) OR (partners.userid={$partnerid} AND partners.partnerid={$userid}) ";
        $query .= "LIMIT 1";

        $db->setQuery($query);
        $result = $db->loadResult();
        
        return $result;
    }
    
    
    public function hasProfile() {   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id FROM #__hpmembers WHERE userid='$user->id'";
        $db->setQuery($query);
        
        return $db->loadResult();
    }
}

