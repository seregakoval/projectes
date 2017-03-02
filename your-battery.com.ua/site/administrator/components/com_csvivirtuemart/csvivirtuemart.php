<?php
/**
* Admin interface
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart.php 1149 2010-02-03 11:51:28Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/* Load the logger */
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'log.php');

/* Get the database object */
$db = JFactory::getDBO();

/* Do some requirement checks */
$checks = true;
$check_msg = array();
/* Check to see if the user uses at least PHP 5 */
if (version_compare(phpversion(), '5', '<') == '-1') {
	$php5_message = str_replace('[version]', phpversion(), JText::_('NO_PHP5'));
	if (JRequest::getBool('cron')) echo $php5_message;
	else {
		$check_msg[] = '<img src="'.$mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/images/help_32.png" alt="'.$php5_message.'" /> '.$php5_message;
	}
	$checks = false;
}

/* Check to see if VirtueMart is installed */
$q = "SELECT COUNT(id) AS total FROM #__components where link = 'option=com_virtuemart';";
$db->setQuery($q);

if ($db->loadResult() == 0) {
	if (JRequest::getBool('cron')) echo JText::_('NO_VIRTUEMART');
	else {
		$check_msg[] = '<img src="'.$mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/images/help_32.png" alt="'.JText::_('NO_VIRTUEMART').'" /> '.JText::_('NO_VIRTUEMART');
	}
	$checks = false;
}

/* Check if all of the requirements are met */

if (!$checks) {
	if (!JRequest::getBool('cron')) echo '<img src="'.$mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/images/logo.png" alt="CSV Improved"/>';
	foreach ($check_msg as $key => $msg) {
		echo '<div>'.$msg.'</div>';
	}
}
else {
	/* See if we get the hostname via cron */
	if (JRequest::getBool('cron', false)) $uri = JURI::getInstance($_SERVER['SERVER_ADDR']);
	else $uri = JURI::getInstance(); 
	
	/* Check if the license is valid */
	/* Check for server address or hostname */
	$hostname = $uri->toString(array('host'));
	$domainname = $uri->toString(array('scheme', 'host'));
	require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'settings.php');
	$settings = new CsvivirtuemartModelSettings();
	$paramshost = $settings->getSetting('hostname');
	if ($paramshost != $domainname) $domainname = $paramshost;
	
	/* Check for the trailing slash at the domain name */
	if (substr($domainname, -1) == '/') $domainname = substr($domainname, 0, -1);
	
	JRequest::setVar('hostname', $hostname);
	JRequest::setVar('domainname', $domainname);
	
	/* Do the subscription check */
	require_once (JPATH_COMPONENT.DS.'helpers'.DS.'subscription_check.php');
	$check = new SubscriptionCheck;
	$result = $check->CheckKey($hostname);
	
	/* Print out the results */
	if ($result['errorcode'] > 0 ) {
		if (JRequest::getBool('cron')) echo $result['result'];
		else $mainframe->enqueueMessage($result['result'], 'error');
	}
	
    /**
   * Admin interface
   *
    */
    if (JRequest::getBool('cron', false)) {
		/* Override preview in cron mode */
		JRequest::setVar('was_preview', true);
    }
    else {
		/* Not doing cron, so set it to false */
		JRequest::setVar('cron', false);
	
		/* Add stylesheets */
		$document = JFactory::getDocument();
		$document->addStyleSheet($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/css/images.css');
		$document->addStyleSheet($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/css/display.css');
		$document->addStyleSheet($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/css/tables.css');
		$document->addStyleSheet($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/css/jquery.alerts.css');
	
		/* Add javascript */
		$document->addScript($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/js/jquery.js');
		$document->addScriptDeclaration('jQuery.noConflict();');
		$document->addScript($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/js/jquery.alerts.js');
		$document->addScript($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/js/jquery.timers.js');
		$document->addScript($mainframe->getSiteURL().'administrator/components/com_csvivirtuemart/assets/js/csvi.js');
    }

    /* Require the base controller */
    require_once (JPATH_COMPONENT.DS.'controller.php');

    /* Require specific controller if requested */
    $controller = JRequest::getVar('controller');
    
    if($controller) {
    	require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');
    }

    /* Create the controller */
    $classname   = 'CsvivirtuemartController'.$controller;
    $controller = new $classname();
    
    /* Perform the Request task */
    $controller->execute(JRequest::getVar('task', JRequest::getVar('controller', 'csvivirtuemart')));

    /* Redirect if set by the controller */
    $controller->redirect();
}
?>