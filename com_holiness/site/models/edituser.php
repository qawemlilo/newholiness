<?php
defined('_JEXEC') or die('Restricted access');


// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
require_once(dirname(__FILE__) . DS . 'tables' . DS . 'user.php');


class HolinessModelEdituser extends JModelItem
{
    public function getTable($type = 'User', $prefix = 'HolinessTable', $config = array()) {
        return JTable::getInstance($type, $prefix, $config);
    }
    
    public function getMember() {   
        $db = JFactory::getDBO();
        $user = JFactory::getUser();
        
        $query = "SELECT member.church, member.imgext, member.id AS memberid, user.id, user.name, user.email ";
        $query .= "FROM #__hpmembers AS member ";
        $query .= "INNER JOIN #__users AS user ";
        $query .= "ON member.userid=user.id ";
        $query .= "WHERE user.id={$user->id}";
        
        $db->setQuery($query); 

		$result = $db->loadObject();
        
        return $result;
    }
}

