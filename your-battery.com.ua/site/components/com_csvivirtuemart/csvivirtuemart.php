<?php
/**
* Admin interface
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 Roland Dalmulder
* @version $Id: csvivirtuemart.php 1132 2010-01-18 21:31:06Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Admin interface
*
*/
/* Make sure we are coming in via index2.php, if not redirect to it */
$mainframe = JFactory::getApplication();
$uri = JURI::getInstance();
$format = $uri->getVar('format', false);
if ($uri->_path == '/index.php' || !$format) {
	$uri->_path = str_replace('/index.php', '/index2.php', $uri->_path);
	$uri->setVar('format', 'raw');
	$mainframe->redirect($uri->toString());
}
 
 
 
/* Require the base controller */
require_once (JPATH_COMPONENT.DS.'controller.php');

/* Require specific controller if requested */
if($controller = JRequest::getVar('controller', 'export')) {
   require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
}

/* Create the controller */
$classname   = 'CsvivirtuemartController'.$controller;
$controller = new $classname();

/* Perform the Request task */
$controller->execute(JRequest::getVar('view'));

/* Redirect if set by the controller */
$controller->redirect();
?>