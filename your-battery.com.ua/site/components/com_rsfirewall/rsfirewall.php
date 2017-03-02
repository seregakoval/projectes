<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the controller
require_once (JPATH_COMPONENT.DS.'controller.php');

// Create the controller
$controller = new RSFirewallController();

// Perform the Request task
$controller->execute(JRequest::getVar('task', null));

// Redirect if set by the controller
$controller->redirect();
?>