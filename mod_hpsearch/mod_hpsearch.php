<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once(dirname(__FILE__).DS.'helper.php');

$user = JFactory::getUser();
$member = ModHPSearchHelper::getProfile();

if ($member) {
    $src = 'src="' . JURI::base() . 'media/com_holiness/images/user-' . $user->id . '-icon.' . $member->imgext . '"';
}
else {
    $src = 'src="data:image/gif;base64,R0lGODlhAQABAIAAAP7//wAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=="';
}

require(JModuleHelper::getLayoutPath('mod_hpsearch'));