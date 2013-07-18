<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
require_once(dirname(__FILE__).DS.'helper.php');

$user = JFactory::getUser();
$member = ModHPSearchHelper::getProfile();
$src = JURI::base() . 'media/com_holiness/images/user-' . $user->id . '-icon.' . $member->imgext;

require(JModuleHelper::getLayoutPath('mod_hpsearch'));