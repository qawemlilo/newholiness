<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
// import Joomla table library
jimport('joomla.database.table');


class HolinessTablePartners extends JTable
{
    function __construct(&$db) 
    {
        parent::__construct('#__devotion_partners', 'id', $db);
    }
}