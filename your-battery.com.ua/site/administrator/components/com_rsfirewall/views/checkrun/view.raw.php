<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewCheckRun extends JView
{
	function display( $tpl = null )
	{
		$task = JRequest::getVar('task');
		if ($task == 'misc')
		{
			$this->assignRef('tempIsOutside', $this->get('tempOutsideResult'));
			$this->assignRef('logIsOutside', $this->get('LogOutsideResult'));
			$this->assignRef('tempFiles', $this->get('tempFilesResult'));
			$this->assignRef('configurationIsOk', $this->get('configurationResult'));
			$this->assignRef('configurationErrors', $this->get('configurationErrors'));
			$this->assignRef('configurationIsOutside', $this->get('configurationOutsideResult'));
			
			$this->assignRef('PHPSettings', $this->get('PHPSettings'));
			$this->assignRef('wrong_php', $this->get('wrongPHP'));
			
			$this->assignRef('adminActive', $this->get('adminActive'));
			$this->assignRef('weakPasswords', $this->get('weakPasswords'));
			
			$this->assignRef('JUMIVulnerable', $this->get('JUMIVulnerable'));
			
			$this->assignRef('joomlaConfiguration', $this->get('joomlaConfiguration'));
			parent::display('misc');
			
			return;
		}
		
		$this->assignRef('response', $this->get('response'));
		parent::display($tpl);
	}
}