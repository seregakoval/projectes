<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelFix extends JModel
{
	var $ignore_files_folders = array();
	
	function __construct()
	{
		parent::__construct();
		$this->_db =& JFactory::getDBO();
	}
	
	function _getIgnoredFilesFolders()
	{
		$this->_db->setQuery("SELECT `path` FROM #__rsfirewall_ignored WHERE `type`='ignore_files_folders'");
		$this->ignore_files_folders = $this->_db->loadResultArray();
		if (!is_array($this->ignore_files_folders))
			$this->ignore_files_folders = array();
	}
	
	function getFiles()
	{
		$session =& JFactory::getSession();
		
		return $session->get('rsfirewall_files', array());
	}
	
	function getFolders()
	{
		$session =& JFactory::getSession();
		
		return $session->get('rsfirewall_folders', array());
	}
	
	function fixFilePermissions()
	{
		$this->_getIgnoredFilesFolders();
		$this->setPermissions(JPATH_SITE, '0644', null);
	}
	
	function fixFolderPermissions()
	{
		$this->_getIgnoredFilesFolders();
		$this->setPermissions(JPATH_SITE, null, '0755');
	}
	
	function getPatterns()
	{
		$session =& JFactory::getSession();
		
		return $session->get('rsfirewall_patterns', array());
	}
	
	function fixPatterns()
	{
		jimport('joomla.filesystem.file');
		$patterns = $this->getPatterns();
		
		if (!empty($patterns))
			foreach ($patterns as $file => $pattern)
				JFile::delete($file);
	}
	
	function fixTempFiles()
	{
		jimport('joomla.filesystem.file');
		$config =& JFactory::getConfig();
		$tmp_path = $config->getValue('config.tmp_path');
		$files = JFolder::files($tmp_path, '', true, true, array('index.html'));
		if (is_array($files))
			JFile::delete($files);
		
		return $files;
	}
	
	function fixPHP()
	{
		$contents = array();
		
		$contents[] = 'register_globals=Off';
		$contents[] = 'safe_mode=Off';
		$contents[] = 'allow_url_fopen=Off';
		$contents[] = 'allow_url_include=Off';
		$contents[] = 'disable_functions=show_source, system, shell_exec, passthru, exec, phpinfo, popen, proc_open';
		
		$config =& JFactory::getConfig();
		
		$delimiter = ':';
		if (substr(PHP_OS, 0, 3) == 'WIN')
			$delimiter = ';';
		
	 	//$root = JPath::clean($_SERVER['DOCUMENT_ROOT']);
		$root = JPATH_SITE;
		$open_basedir[] = $root;
		
	 	$path = JPath::clean($config->getValue('config.tmp_path'));
		if (strpos($path,$root) === false)
		 	$open_basedir[] = $path;
		
	 	$path = JPath::clean($config->getValue('config.log_path'));
		if (strpos($path,$root) === false)
		 	$open_basedir[] = $path;
			
		$path = ini_get('upload_tmp_dir');
		if (!empty($path) && strpos($path,$root) === false && !in_array($path, $open_basedir))
			$open_basedir[] = $path;
		
		if (!in_array(JPATH_CONFIGURATION, $open_basedir))
			$open_basedir[] = JPATH_CONFIGURATION;
		
		$isset = ini_get('open_basedir');
		if (empty($isset))
			$contents[] = 'open_basedir='.implode($delimiter, $open_basedir);
		
		$contents = implode("\r\n", $contents);
		
		if (!is_writable(JPATH_SITE.DS.'php.ini') && !is_writable(JPATH_SITE.DS))
			return $contents;
		
		if (JFile::write(JPATH_SITE.DS.'php.ini', $contents))
			return true;
		else
			return $contents;
	}
	
	function fixAdmin()
	{
		$mainframe =& JFactory::getApplication();
		
		if (RSFirewallHelper::isJ16())
		{
			$this->_db->setQuery("SELECT `id` FROM #__users WHERE `username`='admin' LIMIT 1");
			$id = $this->_db->loadResult();
			$mainframe->redirect('index.php?option=com_users&view=user&layout=edit&id='.$id, JText::_('RSF_FIX_ADMIN'));
		}
		else
		{
			$this->_db->setQuery("SELECT `id` FROM #__users WHERE `username`='admin' AND `gid` > 22 LIMIT 1");
			$id = $this->_db->loadResult();
			$mainframe->redirect('index.php?option=com_users&view=user&task=edit&cid[]='.$id, JText::_('RSF_FIX_ADMIN'));
		}
	}
	
	function fixUser()
	{
		$mainframe =& JFactory::getApplication();
		$username = $this->_db->getEscaped(JRequest::getVar('username'));
		$this->_db->setQuery("SELECT `id` FROM #__users WHERE `username`='".$username."' LIMIT 1");
		$id = $this->_db->loadResult();
		if (RSFirewallHelper::isJ16())
			$mainframe->redirect('index.php?option=com_users&view=user&layout=edit&id='.$id, JText::_('RSF_FIX_USER'));
		else
			$mainframe->redirect('index.php?option=com_users&view=user&task=edit&cid[]='.$id, JText::_('RSF_FIX_USER'));
	}
	
	function fixAcceptChange()
	{
		$file = base64_decode(JRequest::getVar('file', '', 'get', 'base64'));
		$this->_db->setQuery("SELECT `id` FROM #__rsfirewall_hashes WHERE `file`='".$this->_db->getEscaped($file)."' AND `type`='ignore'");
		$this->_db->query();
		if (file_exists(JPATH_SITE.DS.$file))
			$md5 = md5_file(JPATH_SITE.DS.$file);
		else
			$md5 = '';
		if ($this->_db->getNumRows() == 0)
			$query = "INSERT INTO #__rsfirewall_hashes SET `file`='".$this->_db->getEscaped($file)."', `hash`='".$md5."', `type`='ignore', `date`='".time()."'";
		else
		{
			$id = $this->_db->loadResult();
			$query = "UPDATE #__rsfirewall_hashes SET `file`='".$this->_db->getEscaped($file)."', `hash`='".$md5."', `type`='ignore', `date`='".time()."' WHERE `id`='".$id."'";
		}
		
		$this->_db->setQuery($query);
		$this->_db->query();
	}
	
	function fixJUMI()
	{
		$return = array();
		
		$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jumi'.DS.'install.package.php';
		if (!JFile::exists($file))
			return $return;
		
		$contents = JFile::read($file);
		if (strpos($contents, 'eval(gzinflate(base64_decode') !== false)
		{
			$new = new stdClass();
			$new->file = $file;
			
			$pattern = '#eval\(gzinflate\(base64_decode\((.*)\)\)\);#';
			if (preg_match($pattern, $contents, $match))
				$contents = str_replace($match[0], '', $contents);
			$cleaned = JFile::write($file, $contents);
			$new->what = $cleaned ? 'Cleaned' : 'Could not clean';
			
			$return[] = $new;
		}
		
		$files = array(JPATH_SITE.DS.'tmp'.DS.'.config.php', JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_mainmenu'.DS.'tmpl'.DS.'.config.php', JPATH_SITE.DS.'modules'.DS.'mod_mainmenu'.DS.'tmpl'.DS.'.config.php');
		foreach ($files as $file)
			if (JFile::exists($file))
			{
				$new = new stdClass();
				$new->file = $file;
				$deleted = JFile::delete($file);
				$new->what = $deleted ? 'Removed' : 'Could not remove';
				
				$return[] = $new;
			}
			
		return $return;
	}
	
	function fixConfiguration()
	{
		$mainframe =& JFactory::getApplication();
		$mainframe->redirect('index.php?option=com_config', JText::_('RSF_FIX_CONFIGURATION'));
	}
	
	function setPermissions($path, $filemode = '0644', $foldermode = '0755')
	{
		// Initialize return value
		$ret = true;
		
		if (is_dir($path))
		{
			$dh = opendir($path);
			while ($file = readdir($dh))
			{
				if ($file != '.' && $file != '..' && !in_array($path.DS.$file, $this->ignore_files_folders))
				{
					$fullpath = $path.DS.$file;
					if (is_dir($fullpath)) {
						if (!$this->setPermissions($fullpath, $filemode, $foldermode)) {
							$ret = false;
						}
					} else {
						if (isset ($filemode)) {
							if (!@ chmod($fullpath, octdec($filemode))) {
								$ret = false;
							}
						}
					} // if
				} // if
			} // while
			closedir($dh);
			if (isset ($foldermode) && !in_array($path, $this->ignore_files_folders)) {
				if (!@ chmod($path, octdec($foldermode))) {
					$ret = false;
				}
			}
		}
		else
		{
			if (isset ($filemode) && !in_array($path, $this->ignore_files_folders)) {
				$ret = @ chmod($path, octdec($filemode));
			}
		} // if
		return $ret;
	}
}
?>