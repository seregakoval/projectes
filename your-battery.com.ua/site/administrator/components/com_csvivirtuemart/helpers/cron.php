<?php
/**
* Cron handler
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: cron.php 1149 2010-02-03 11:51:28Z Roland $
 */
 
/**
* Cron handler
 */
/* Get the Joomla framework */
define( '_JEXEC', 1 );
define( 'DS', DIRECTORY_SEPARATOR );
define('JPATH_BASE', substr(str_ireplace('administrator/components/com_csvivirtuemart/helpers/cron.php', '', str_ireplace('\\', '/', __FILE__)), 0, -1));
define('JPATH_COMPONENT_ADMINISTRATOR', JPATH_BASE.DS.'administrator'.DS.'components'.DS.'com_csvivirtuemart');
define('JPATH_COMPONENT', JPATH_COMPONENT_ADMINISTRATOR);
$_SERVER['REQUEST_METHOD'] = 'post';
$_SERVER['HTTP_HOST'] = '';
$_SERVER['REMOTE_ADDR'] = gethostbyname('localhost');
require_once ( JPATH_BASE.DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE.DS.'includes'.DS.'framework.php' );
require_once ( JPATH_BASE.DS.'administrator'.DS.'includes'.DS.'toolbar.php' );

/* Create the Application */
$mainframe = JFactory::getApplication('administrator');
$mainframe->initialise();

/* Load the language file */
$language = JFactory::getLanguage();
$language->load('com_csvivirtuemart', JPATH_BASE.DS.'administrator');

/* Load the plugin system */
JPluginHelper::importPlugin('system');

// trigger the onAfterInitialise events
$mainframe->triggerEvent('onAfterInitialise');

/**
* Handles all cron requests
*
* @package CSVIVirtueMart
 */
class CsviCron {
	
	/** @var $basepath string the base of the installation */
	var $basepath = '';
	
	/**
	* Initialise some settings
	 */
	function CsviCron() {
		$db = JFactory::getDBO();
		
		$this->CollectVariables();
		/* First check if we deal with a valid user */
		if ($this->Login()) {
			/* Set some global values */
			/* Get the parameters */
			require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'models'.DS.'settings.php');
			$settings = new CsvivirtuemartModelSettings();
			
			/* Check if we are running cron mode and set some necessary variables */
			$_SERVER['SERVER_ADDR'] = $_SERVER['HTTP_HOST'] = $settings->getSetting('hostname');
			$_SERVER['SCRIPT_NAME'] = '/index.php';
			$_SERVER['REQUEST_URI'] = '/';
			$_SERVER['PHP_SELF'] = '/index.php';
			
			/* Get the task to do */
			$task = JRequest::getString('task', '');
			
			/* Perform the requested task */
			switch ($task) {
				case 'maintenance':
					JRequest::setVar('operation', array(JRequest::getCmd('operation')));
					JRequest::setVar('boxchecked', 1);
					/* Fire CSVI VirtueMart  */
					$this->ExecuteJob();
					break;
				default:
					/* Second check if any template is set to process */
					$template_name = JRequest::getString('template_name', '');
					if ($template_name) {
						/* There is a template name, get some details to streamline processing */
						$q = "SELECT template_id, template_type 
							FROM #__csvivirtuemart_templates 
							WHERE template_name = ".$db->Quote($template_name);
						$db->setQuery($q);
						$row = $db->loadObject();
						if (is_object($row)) {
							if ($row->template_type) {
								/* Set the export type */
								if (stristr($row->template_type, 'export')) {
									JRequest::setVar('task', 'exportfile');
									JRequest::setVar('controller', 'exportfile');
								}
								else {
									JRequest::setVar('task', 'importfile');
									JRequest::setVar('controller', 'importfile');
								}
								/* Set the template ID */
								JRequest::setVar('template_id', $row->template_id);
								
								/* Set the file details */
								/* Set output to file as we cannot download anything */
								JRequest::setVar('exportto', 'tofile');
								
								/* Get the filename from the user input */
								if (JRequest::getCmd('filename', false)) {
									JRequest::setVar('local_csv_file', JRequest::getString('filename'));
									/* Tell the system it is a local file */
									JRequest::setVar('selectfile', 2);
								}
								else {
									/* Tell the system there is no file */
									JRequest::setVar('selectfile', 0);
								}
								/* Fire CSVI VirtueMart  */
								$this->ExecuteJob();
							}
						}
						else echo JText::_('No template found with the name '.$template_name);
					}
					else echo JText::_('No template name specified');
					break;
			}
		}
		else {
			$error = JError::getError();
			echo $error->message;
		}
		
		/* Done, lets log the user out */
		$this->UserLogout();
	}
	
	/**
	* Collect the variables
	*
	* Running from the command line, the variables are stored in $argc and $argv.
	* Here we put them in $_REQUEST so that they are available to the script
	 */
	private function CollectVariables() {
		/* Take the argument values and put them in $_REQUEST */
		if (isset($_SERVER['argv'])) {
			foreach ($_SERVER['argv'] as $key => $argument) {
				if ($key > 0) {
					list($name, $value) = explode("=", $argument);
					if (strpos($value, '|')) $value = explode('|', $value);
					JRequest::setVar($name, $value);
				}
			}
		}
	}
	
	/**
	* Check if the user exists
	 */
	private function Login() {
		global $mainframe;
		
		$credentials['username'] = JRequest::getVar('username', '', 'method', 'username');
		$credentials['password'] = JRequest::getVar('passwd', '', 'method', 'string');
		
		$result = $mainframe->login($credentials, array('entry_url' => ''));
		
		if (!JError::isError($result)) {
			return true;
		}
		else return false;
	}
	 
	/**
	* Process the requested job
	 */
	function ExecuteJob() {
		JRequest::setVar('cron', true);
		require(JPATH_COMPONENT_ADMINISTRATOR.DS.'csvivirtuemart.php');
	}
	
	/**
	* Log the user out
	 */
	private function UserLogout() {
		global $mainframe;
		ob_start();
		$error = $mainframe->logout();
		
		if(JError::isError($error)) {
			ob_end_clean();
			echo JText::_('PROBLEM_LOGOUT_USER');
		}
		else {
			ob_end_clean();
			echo JText::_('USER_LOGGED_OUT');
		}
	}
}
$csvicron = new CsviCron;
?>