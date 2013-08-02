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
    

    public function getProfile() {   
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id, userid, imgext, church FROM #__hpmembers WHERE userid='$user->id'";
        $db->setQuery($query); 

        $result = $db->loadObject();
        
        return $result;
    }
    
    
    public function unpublish($id) {   
        $db =& JFactory::getDBO();

        if (!$id) {
            return false;
        }
        
        $query = "UPDATE #__devotions SET published=0 WHERE id=$id";
        $db->setQuery($query); 

        $result = $db->loadResult();
        
        return $result;
    }
    
    
    
    public function getComments($id)
	{   
        $db =& JFactory::getDBO();
        
        $query = "SELECT comment.id AS commentid, comment.userid AS id, comment.txt AS comment, comment.ts, member.imgext, user.name ";
        $query .= "FROM #__devotion_comments AS comment ";
        $query .= "INNER JOIN #__hpmembers AS member ";
        $query .= "ON member.userid=comment.userid ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $query .= "WHERE comment.devotionid=$id";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
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
    
    
    public function getDevotions($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT id, theme, memberid ";
        $query .= "FROM #__devotions ";
        $query .= "WHERE memberid=$id";
        
        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
}

