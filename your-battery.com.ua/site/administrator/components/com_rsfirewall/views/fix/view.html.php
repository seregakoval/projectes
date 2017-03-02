<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class RSFirewallViewFix extends JView
{
	function display( $tpl = null )
	{		
		$what = JRequest::getVar('what');
		$fix = $this->getModel('fix');
		
		switch ($what)
		{	
			case 'integrity':
			parent::display('integrity');
			break;
		
			case 'folderPermissions':
			$fix->fixFolderPermissions();
			parent::display('folderpermissions');
			break;
			
			case 'filePermissions':
			$fix->fixFilePermissions();
			parent::display('filepermissions');
			break;
			
			case 'patterns':
			$files = $this->get('patterns');
			$fix->fixPatterns();
			$this->assignRef('files', $files);
			parent::display('patterns');
			break;
			
			case 'php':
			$fixPHP = $fix->fixPHP();
			$this->assignRef('fixPHP', $fixPHP);
			parent::display('php');
			break;
			
			case 'jumi':
			$fixJUMI = $fix->fixJUMI();
			$this->assignRef('fixJUMI', $fixJUMI);
			parent::display('jumi');
			break;
			
			case 'admin':
			$fix->fixAdmin();
			break;
			
			case 'user':
			$fix->fixUser();
			break;
			
			case 'tempFiles':
			$files = $fix->fixTempFiles();
			$this->assignRef('files', $files);
			parent::display('tempfiles');
			break;
			
			case 'acceptChange':
			$fix->fixAcceptChange();
			break;
			
			case 'configuration':
			$fix->fixConfiguration();
			break;
		}
	}
}