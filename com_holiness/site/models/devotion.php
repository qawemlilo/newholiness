<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'devotion.php');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'comment.php');


class HolinessModelDevotion extends JModelItem
{
    public function getTable($type = 'Devotion', $prefix = 'HolinessTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }
    

    public function getProfile($userid) {   
        $db = JFactory::getDBO();
        
        $query = "SELECT id, userid, imgext, church FROM #__hpmembers WHERE userid=$userid";
        $db->setQuery($query); 

        $result = $db->loadObject();
        
        return $result;
    }
    
    
    public function unpublish($id) {   
        $db = JFactory::getDBO();

        if (!$id) {
            return false;
        }
        
        $query = "UPDATE #__devotions SET published=0 WHERE id=$id";
        $db->setQuery($query); 

        $result = $db->loadResult();
        
        return $result;
    }
    
    
    
    public function getComments($id) {   
        $db = JFactory::getDBO();
        
        $query = "SELECT comment.id , comment.userid, comment.comment_type, comment.txt AS comment, comment.amens, comment.ts, member.imgext, user.name ";
        $query .= "FROM #__hp_comments AS comment ";
        $query .= "INNER JOIN #__hpmembers AS member ";
        $query .= "ON member.userid=comment.userid ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $query .= "WHERE comment.devotionid=$id ";
        $query .= "ORDER BY ts DESC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    public function getMe($userid) {   
        $db = JFactory::getDBO();
        
        $query = "SELECT user.id, user.name, user.email, user.username, member.imgext ";
        $query .= "FROM #__users AS user ";
        $query .= "INNER JOIN #__hpmembers AS member ";
        $query .= "ON user.id=member.userid ";
        $query .= "WHERE user.id=$userid";
        
        $db->setQuery($query); 

        $result = $db->loadObject();
        
        return $result;
    }
    
    
    
    public function addComment($arr = array()) {
        $table = $this->getTable('Comment');
            
        if (!$table->bind( $arr )) {
            return false;
        }
        if (!$table->store( $arr )) {
            return false;
        }
                
        return $table->id;
    }
    
    
    
    public function addAmen($id, $userid) {
        $table = $this->getTable('Comment');
        
        if (!$table->load($id)) {
            return false;
        }
        
        $amens = $table->amens;
        
        if ($amens) {
            $amens .= ',' . $userid;
        }
        else {
            $amens = $userid . '';
        }
        
        $arr = array('amens'=>$amens);
            
        if (!$table->bind( $arr )) {
            return false;
        }
        
        if (!$table->store( $arr )) {
            return false;
        }
                
        return true;;
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
        
        if ($table->memberid != $arr['memberid']) {
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
    
    
    public function getDevotion($id) {
        $db = JFactory::getDBO();
        
        $query = "SELECT devotions.*, members.userid, members.church, members.imgext, users.name, users.email ";
        $query .= "FROM #__devotions AS devotions ";
        $query .= "INNER JOIN #__hpmembers AS members ";
        $query .= "ON devotions.memberid=members.id ";
        $query .= "INNER JOIN #__users AS users ";
        $query .= "ON members.userid=users.id ";
        $query .= "WHERE devotions.id=$id";
        
        $db->setQuery($query);
        $result = $db->loadObject();
        
        return $result;
    }
    
    
    function getParners($userid) {
        $db = JFactory::getDBO();
        
        $query = "SELECT member.id AS memberid, member.church, member.imgext, user.id, user.name AS value ";
        $query .= "FROM #__hpmembers AS member  ";
        $query .= "INNER JOIN #__devotion_partners AS partner ON partner.partnerid = member.userid ";
        $query .= "INNER JOIN #__users AS user ON member.userid = user.id ";
        $query .= "WHERE partner.userid=$userid AND partner.active=1";
        
        $db->setQuery($query); 

        $data = $db->loadObjectList();

        return $data;
    }
    
    
    public function getDevotions($id) {
        $db = JFactory::getDBO();
        
        $query = "SELECT id, theme, memberid ";
        $query .= "FROM #__devotions ";
        $query .= "WHERE memberid=$id";
        
        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    function getRecentDevotions($mid, $limit = 10) {
        $db = JFactory::getDBO();
        
        $query = "SELECT * FROM #__devotions WHERE memberid={$mid} ORDER BY ts DESC LIMIT {$limit}";
        $db->setQuery($query); 
        
        $results = $db->loadObjectList();

        return $results;
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

