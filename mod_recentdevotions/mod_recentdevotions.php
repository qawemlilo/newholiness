<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(dirname(__FILE__).DS.'helper.php');

$pid = JRequest::getVar('pid', 0);
$limit = $params->get('limit');

$devotions = ModRecentDevotionsHelper::getDevotions($limit, $pid);

require(JModuleHelper::getLayoutPath('mod_recentdevotions'));