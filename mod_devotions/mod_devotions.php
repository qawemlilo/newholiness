<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(dirname(__FILE__).DS.'helper.php');

$devotions = ModDevotionsHelper::getDevotions();


require(JModuleHelper::getLayoutPath('mod_devotions'));