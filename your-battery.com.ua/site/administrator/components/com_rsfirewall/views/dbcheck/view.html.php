<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewDBCheck extends JView
{
	function display( $tpl = null )
	{
		JToolBarHelper::title('RSFirewall!','rsfirewall');
		
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_OVERVIEW'), 'index.php?option=com_rsfirewall');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_CHECK'), 'index.php?option=com_rsfirewall&view=check');
		JSubMenuHelper::addEntry(JText::_('RSF_DB_CHECK'), 'index.php?option=com_rsfirewall&view=dbcheck', true);
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOGS'), 'index.php?option=com_rsfirewall&view=logs');
		JSubMenuHelper::addEntry(JText::_('RSF_SYSTEM_LOCKDOWN'), 'index.php?option=com_rsfirewall&view=lockdown');
		JSubMenuHelper::addEntry(JText::_('RSF_FIREWALL_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=configuration');
		JSubMenuHelper::addEntry(JText::_('RSF_FEEDS_CONFIGURATION'), 'index.php?option=com_rsfirewall&view=feeds');
		JSubMenuHelper::addEntry(JText::_('RSF_UPDATES'), 'index.php?option=com_rsfirewall&view=updates');
		
		$this->assign('root', JURI::root());
		$this->assign('tables', $this->get('tables'));
		
		parent::display($tpl);
	}
	
	function _convert($b)
	{
		if ($b < 1)
			return '0.00';
			
		return number_format($b/1024, 2, '.', ' ');
	}
}