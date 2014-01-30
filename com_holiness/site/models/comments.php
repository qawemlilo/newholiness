<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'comment.php');


class HolinessModelComments extends JModelItem
{
    public function getTable($type = 'Comment', $prefix = 'HolinessTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    
    
    public function getComments($id, $type) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT comment.id , comment.userid, comment.txt AS comment, comment.amens, comment.ts, comment.post_type, member.imgext, user.name ";
        $query .= "FROM #__hp_comments AS comment ";
        $query .= "INNER JOIN #__hpmembers AS member ";
        $query .= "ON member.userid=comment.userid ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $query .= "WHERE comment.postid=$id AND comment.post_type='{$type}' ";
        $query .= "ORDER BY ts DESC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function countComments($id, $type) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT COUNT(*) ";
        $query .= "FROM #__hp_comments AS comment ";
        $query .= "WHERE comment.postid=$id AND comment.post_type='{$type}'";

        $db->setQuery($query);
        $result = $db->loadResult();
        
        return $result;
    }
    
    
    
    public function addComment($arr = array()) {
        $table = $this->getTable();
            
        if (!$table->bind( $arr )) {
            return false;
        }
        
        if (!$table->store( $arr )) {
            return false;
        }
                
        return $table->id;
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
    
    
    
    public function addAmen($id, $userid) {
        $table = $this->getTable();
        
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
}

