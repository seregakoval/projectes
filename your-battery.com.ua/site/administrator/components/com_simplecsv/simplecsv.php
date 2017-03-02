<?php
/**
 * @link http://www.roman7.com
 * @copyright (c) 2010 Roman Nagaev
 * @license GNU/GPL
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

require_once(JPATH_COMPONENT.DS.'controller.php');

$controller   = new SimplecsvController();

$controller->execute(JRequest::getVar('task'));
$controller->redirect();