<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(dirname(__FILE__).DS.'helper.php');


$categories = ModRegisterHelper::getCategories();
$categoriesArray = ModRegisterHelper::createCategoriesArray($categories);


require(JModuleHelper::getLayoutPath('mod_ssnsearch'));