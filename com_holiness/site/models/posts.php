<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'prayerrequest.php');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'plusone.php');


class HolinessModelPosts extends JModelItem
{
    public function getTable($type = 'Prayerrequest', $prefix = 'HolinessTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    
    
    
    public function willPray($userid, $postid) {   
        $db =& JFactory::getDBO();
        
        if ($this->checkPromise($userid, $postid)) {
            return false;
        }
        
        $arr = array('userid'=>$userid, 'postid'=>$postid);
        $result = $this->addPromise($arr);
        
        return $result;
    }
    
    
    
    
    public function iHavePrayed($userid, $postid) {   
        $db =& JFactory::getDBO();
        
        if (!$prayerid = $this->checkPromise($userid, $postid)) {
            return false;
        }
        
        $arr = array('prayed'=>1);
        $result = $this->updatePromise($prayerid, $arr);
        
        return $result;
    }
    
    
    
    public function getPlusones($id, $type) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT plusone.id, plusone.userid, user.name ";
        $query .= "FROM #__hp_plusone AS plusone ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON plusone.userid=user.id ";
        $query .= "WHERE plusone.postid=$id AND plusone.post_type='{$type}' ";
        $query .= "ORDER BY ts ASC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function getPlusoneNotes() {   
        $db =& JFactory::getDBO();
        $user = JFactory::getUser();
        
        $query = "SELECT plusone.id, plusone.postid, plusone.userid, plusone.post_type, plusone.ts ";
        $query .= "FROM #__hp_plusone AS plusone ";
        $query .= "WHERE plusone.flag=0 AND plusone.userid!=$user->id AND (plusone.postid IN (SELECT id FROM #__hp_timeline WHERE userid=$user->id)) ";
        $query .= "ORDER BY plusone.ts DESC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function updateNotes() {   
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        
        $query = "UPDATE #__hp_plusone AS plusone SET plusone.flag=1 ";
        $query .= "WHERE plusone.flag=0 AND (plusone.postid IN (SELECT id FROM #__hp_timeline WHERE userid=$user->id)) ";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function getPostComments($id) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT plusone.id, plusone.postid, plusone.userid, plusone.post_type, plusone.ts ";
        $query .= "FROM #__hp_plusone AS plusone ";
        $query .= "WHERE plusone.flag=0 AND plusone.userid!=$id AND (plusone.postid IN (SELECT id FROM #__hp_timeline WHERE userid=$id)) ";
        $query .= "ORDER BY plusone.ts DESC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function getDevotionComments($id) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT plusone.id, plusone.postid, plusone.userid, plusone.post_type, plusone.ts ";
        $query .= "FROM #__hp_plusone AS plusone ";
        $query .= "WHERE plusone.flag=0 AND plusone.userid!=$id AND (plusone.postid IN (SELECT id FROM #__hp_timeline WHERE userid=$id)) ";
        $query .= "ORDER BY plusone.ts DESC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    public function getWillprays($id) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT prayerrequest.id, prayerrequest.userid, prayerrequest.prayed, user.name ";
        $query .= "FROM #__hp_prayerrequest AS prayerrequest ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON prayerrequest.userid=user.id ";
        $query .= "WHERE prayerrequest.postid=$id ";
        $query .= "ORDER BY ts ASC";

        $db->setQuery($query);
        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    
    
    public function plusOne($userid, $postid, $post_type) {   
        $db =& JFactory::getDBO();
        
        if ($this->checkPlusone($userid, $postid, $post_type)) {
            return false;
        }
        
        $arr = array('userid'=>$userid, 'postid'=>$postid, 'post_type'=>$post_type);
        $result = $this->addPlusone($arr);
        
        return $result;
    }
    
    
    
    public function checkPromise($userid, $postid) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT prayer.id ";
        $query .= "FROM #__hp_prayerrequest AS prayer ";
        $query .= "WHERE prayer.userid=$userid AND prayer.postid=$postid";

        $db->setQuery($query);
        $result = $db->loadResult();
        
        return $result;
    }
    
    
    
    public function checkPlusone($userid, $postid, $post_type) {   
        $db =& JFactory::getDBO();
        
        $query = "SELECT plusone.id ";
        $query .= "FROM #__hp_plusone AS plusone ";
        $query .= "WHERE plusone.userid=$userid AND plusone.postid=$postid AND plusone.post_type='$post_type'";

        $db->setQuery($query);
        $result = $db->loadResult();
        
        return $result;
    }
    
    
    
    private function addPromise($arr) {
        $table = $this->getTable();
            
        if (!$table->bind($arr)) {
            return false;
        }
        
        if (!$table->store($arr)) {
            return false;
        }
                
        return $table->id;
    }
    
    
    
    private function updatePromise($id, $arr) {
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
    
    
    
    private function addPlusone($arr) {
        $table = $this->getTable('Plusone');
            
        if (!$table->bind($arr)) {
            return false;
        }
        
        if (!$table->store($arr)) {
            return false;
        }
                
        return $table->id;
    }
}

