<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class RSFirewallController extends JController
{
	var $_db;
	
	function __construct()
	{
		parent::__construct();
		
		if (RSFirewallHelper::isJ16())
			JHTML::_('behavior.framework');
		
		$document =& JFactory::getDocument();
		// Add the css stylesheet
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_rsfirewall/assets/css/rsfirewall.css');
		// Add the rsfirewall js
		$document->addScript(JURI::root(true).'/administrator/components/com_rsfirewall/assets/js/rsfirewall.js');
		if (RSFirewallHelper::isJ16())
			$document->addStyleSheet(JURI::root(true).'/administrator/components/com_rsfirewall/assets/css/rsfirewall-j16.css');
		
		// Set the database object
		$this->_db =& JFactory::getDBO();
		
		RSFirewallHelper::readConfig();
	}
	
	function fixAdminMenus()
	{
		$mainframe 	=& JFactory::getApplication();
		$db 		=& JFactory::getDBO();
		
		$db->setQuery("SELECT id FROM #__menu WHERE `id`='1'");
		if (!$db->loadResult())
		{
			$db->setQuery("INSERT IGNORE INTO `#__menu` (`id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `ordering`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`) VALUES (1, '', 'Menu_Item_Root', 'root', '', '', '', '', 1, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, 0, '', 0, '', 0, 93, 0, '*', 0)");
			$db->query();
		}
		
		$db->setQuery("SELECT extension_id FROM #__extensions WHERE `element`='com_rsfirewall' AND `type`='component'");
		$db->setQuery("UPDATE #__menu SET component_id='".$db->loadResult()."' WHERE id > 1 AND component_id=0 AND `type`='component' AND `link` LIKE 'index.php?option=com_rsfirewall%'");
		$db->query();
		
		$mainframe->redirect('index.php?option=com_rsfirewall', JText::_('RSF_FIX_ADMIN_MENUS_ATTEMPTED'));
	}
	
	/**
	 * Display the view
	 */
	function display()
	{
		parent::display();
	}
	
	/**
	 * Display "System Check"
	 */
	function check()
	{
		JRequest::setVar('view', 'check');
		parent::display();
	}
	
	/**
	 * Display "Firewall Configuration"
	 */
	function configuration()
	{
		JRequest::setVar('view', 'configuration');
		parent::display();
	}
	
	/**
	 * Display "System Logs"
	 */
	function logs()
	{
		JRequest::setVar('view', 'logs');
		parent::display();
	}
	
	/**
	 * Display "System Lockdown"
	 */
	function lockdown()
	{
		JRequest::setVar('view', 'lockdown');
		parent::display();
	}
	
	/**
	 * Display "Feed Configuration"
	 */
	function feeds()
	{
		JRequest::setVar('view', 'feeds');
		parent::display();
	}
	
	function auth()
	{
		JRequest::setVar('view', 'auth');
		parent::display();
	}
	
	function acceptHash()
	{
		$cid = JRequest::getInt('cid');
		if ($cid == 0) return;
		
		jimport('joomla.filesystem.file');
		
		$this->_db->setQuery("SELECT * FROM #__rsfirewall_hashes WHERE `id`='".$cid."' AND `flag` != ''");
		$hash = $this->_db->loadObject();
		
		if (JFile::exists($hash->file))
		{
			if ($hash->type == 'protect')
				$curr_hash = md5_file($hash->file);
			else
				$curr_hash = md5_file(JPATH_SITE.DS.$hash->file);
			$this->_db->setQuery("UPDATE #__rsfirewall_hashes SET `flag`='', `hash`='".$curr_hash."' WHERE `id`='".$cid."' LIMIT 1");
			$this->_db->query();
		}
		$this->setRedirect('index.php?option=com_rsfirewall', JText::_('RSF_HASH_CHANGED_SUCCESS'));
	}
	
	function fix()
	{
		JRequest::setVar('view', 'fix');
		JRequest::setVar('tmpl', 'component');
		parent::display();
	}
	
	function saveRegistration()
	{
		$code = JRequest::getVar('global_register_code');
		$code = $this->_db->getEscaped($code);
		if (!empty($code))
		{
			$this->_db->setQuery("UPDATE #__rsfirewall_configuration SET `value`='".$code."' WHERE `name`='global_register_code'");
			$this->_db->query();

			$this->setRedirect('index.php?option=com_rsfirewall&view=updates', JText::_('RSF_LICENSE_SAVED'));
		}
		else
		{
			$this->setRedirect('index.php?option=com_rsfirewall&view=configuration');
		}
	}
	
	function getLatestJoomlaVersion()
	{
		$latestJoomla = RSFirewallHelper::getLatestJoomlaVersion();
		$currentJoomla = RSFirewallHelper::getCurrentJoomlaVersion();
		
		?>
		<span class="rsfirewall_cpanel_<?php echo RSFirewallHelper::version_compare($currentJoomla, $latestJoomla) ? 'green' : 'red'; ?>"><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $currentJoomla; ?></span><br />
		<span class="rsfirewall_cpanel_green"><?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $latestJoomla; ?></span>
		<?php
		die();
	}
	
	function getLatestFirewallVersion()
	{
		$latestFirewall = RSFirewallHelper::getLatestFirewallVersion();
		$currentFirewall = RSFirewallHelper::getCurrentFirewallVersion();
		
		?>
		<span class="rsfirewall_cpanel_<?php echo RSFirewallHelper::version_compare($currentFirewall, $latestFirewall) ? 'green' : 'red'; ?>"><?php echo JText::_('RSF_INSTALLED_VERSION'); ?> <?php echo $currentFirewall; ?></span><br />
		<span class="rsfirewall_cpanel_green"><?php echo JText::_('RSF_LATEST_VERSION'); ?> <?php echo $latestFirewall; ?></span>
		<?php
		die();
	}
	
	function dbCheckRun()
	{
		$table_name = JRequest::getVar('table_name');
		$this->_db->setQuery("OPTIMIZE TABLE `".$this->_db->getEscaped($table_name)."`");
		$result = $this->_db->loadObject();
		echo $result->Op.': '.$result->Msg_text.', ';
		
		$this->_db->setQuery("REPAIR TABLE `".$this->_db->getEscaped($table_name)."`");
		$result = $this->_db->loadObject();
		echo $result->Op.': '.$result->Msg_text;
		die();
	}
}
?>