<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');


class HolinessTableComment extends JTable
{
    function __construct(&$db) 
    {
        parent::__construct('#__hp_comments', 'id', $db);
    }
}
