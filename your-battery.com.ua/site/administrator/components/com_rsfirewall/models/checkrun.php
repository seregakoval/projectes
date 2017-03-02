<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

class RSFirewallModelCheckRun extends JModel
{
	var $response = '';
	var $offset = 0;
	var $folders = array();
	var $files = array();
	
	function __construct()
	{
		parent::__construct();
		
		@set_time_limit(0);
		
		$task = JRequest::getVar('task');
		switch ($task)
		{
			case 'version':
			// this is the first step so we must reset the grade
			$this->initCheck();
			
			$this->checkVersion();
			break;
			
			case 'integrity':
			$this->checkIntegrity();
			break;
			
			case 'folders':
			$this->checkFolders();
			break;
			
			case 'misc':
			$this->checkMisc();
			break;
			
			case 'grade':
			$this->getGrade();
			break;
		}
	}
	
	function getResponse()
	{
		return $this->response;
	}
	
	function setResponse($string, $append=true)
	{
		$this->response .= $string;
	}
	
	function initCheck()
	{
		$log = new RSFirewallLog();
		$log->page = JURI::root(true).'/index.php?option=com_rsfirewall&view=check';
		$log->addEvent('low', 'START_SYSTEM_CHECK');

		$session =& JFactory::getSession();
		
		// reset the grade
		$session->set('grade', '0');
		
		// integrity scrollable, wrong hashes, missing hashes, uninstalled and total hashes
		$session->set('integrity_scroll', '0');
		$session->set('integrity_wrong', '0');
		$session->set('integrity_missing', '0');
		$session->set('integrity_uninstalled', array());
		$session->set('integrity_nr', '0');
		
		// folder permissions - wrong folders and total folders
		$session->set('folders_wrong', '0');
		$session->set('folders_nr', '0');
		
		// file permissions - wrong files and total files
		$session->set('files_wrong', '0');
		$session->set('files_nr', '0');
	}
	
	function checkVersion()
	{
		$latest = RSFirewallHelper::getLatestJoomlaVersion();
		$current = RSFirewallHelper::getCurrentJoomlaVersion();
		
		$valid = RSFirewallHelper::version_compare($current, $latest);
		if ($valid)
			RSFirewallHelper::grade('+10');
			
		$response = 'joomla|'.$current.'|'.$latest.'|'.($valid ? 'check' : 'nocheck');
		$this->setResponse($response);
		
		$latest = RSFirewallHelper::getLatestFirewallVersion();
		$current = RSFirewallHelper::getCurrentFirewallVersion();
		
		$valid = RSFirewallHelper::version_compare($current, $latest);
		if ($valid)
			RSFirewallHelper::grade('+10');
		
		$response = '|firewall|'.$current.'|'.$latest.'|'.($valid ? 'check' : 'nocheck');
		$this->setResponse($response);
	}
	
	function checkIntegrity()
	{
		$session =& JFactory::getSession();
		$hashes = array();
		
		// get the hash file for the current joomla version
		$current = RSFirewallHelper::getCurrentJoomlaVersion();
		$hash_file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'hashes'.DS.$current.'.csv';
		
		// if we don't have a hash file to compare against, stop and show an error
		$has_hash = JFile::exists($hash_file);
		if (!$has_hash)
		{
			$response = JText::_('RSF_NO_HASH');
			$this->setResponse('STOP|NOHASH|'.$response);
			return;
		}
		
		// let's grab from the database files that we ignore from the check
		$ignored = array();
		$ignored_hashes = array();
		$result = RSFirewallHelper::getIgnoredFiles();
		foreach ($result as $file)
		{
			$ignored[] = $file->file;
			$ignored_hashes[$file->file] = $file->hash;
		}
		
		// setup the offsets
		$i = -1;
		$offset = JRequest::getInt('offset', 0);
		$stop_offset = $offset + RSFirewallHelper::getConfig('offset');
		
		// open the hash file and load the information
		$handle = fopen($hash_file, 'r');
		while (($data = fgetcsv($handle, 1000, ',')) !== false)
		{
			$i++;
			// if we haven't reached the offset just skip the step
			if ($i < $offset) continue;
			// if we reached the stop offset exit the loop
			if ($i == $stop_offset) break;
			
			// create the new element
			$hash = new stdClass();
			$hash->file = $data[0];
			$hash->hash = $data[1];
			
			// if not in the ignored list, add it to the array
			if (!in_array($hash->file, $ignored))
				$hashes[] = $hash;
			else
			{
				// this is a little hack so that even when you ignore a file, every time it changes you will be warned
				// so basically the file will be ignored if it won't be modified anymore
				$db_hash = $ignored_hashes[$hash->file];
				if (file_exists(JPATH_SITE.DS.$hash->file) && md5_file(JPATH_SITE.DS.$hash->file) != $db_hash)
					$hashes[] = $hash;
			}
		}
		fclose($handle);
		
		// this is a list of optional Joomla! files, such as components and templates that can be uninstalled
		// we need to list so we can check them only if they are installed
		$optionals = RSFirewallHelper::getOptionalFiles();
		
		$scrolling = (int) $session->get('integrity_scroll', 0);
		$wrong = (int) $session->get('integrity_wrong', 0);
		$missing = (int) $session->get('integrity_missing', 0);
		
		// stop if there are no more hashes to check
		if (count($hashes) == 0)
		{
			// set the stop response; everything is ok
			$this->setResponse('STOP|OK');
			
			// set the scrolling response; this will indicate if the list of files needs to be scrolled
			if ($scrolling > 12)
				$this->setResponse('|SCROLL');
			else
				$this->setResponse('|NOSCROLL');
			
			// set the wrong files response; this will indicate if there are any files with incorrect hashes
			if (!empty($wrong))
				$this->setResponse('|WRONG');
			else
				$this->setResponse('|'.JText::_('RSF_OK_HASH'));
			
			// set the missing files response; this will indicate if there are any missing files
			if (!empty($missing))
				$this->setResponse('|MISSING');
			else
				$this->setResponse('|'.JText::_('RSF_NOMISSING_HASH'));
			
			// calculate the grade
			$maxfiles = (int) $session->get('integrity_nr', 0);
			if (!empty($wrong))
			{
				$grade = 10 - ($wrong * 10) / $maxfiles;
				RSFirewallHelper::grade($grade);
			}
			else
				RSFirewallHelper::grade('+10');
			
			if (!empty($missing))
			{
				$grade = 10 - ($missing * 10) / $maxfiles;
				RSFirewallHelper::grade($grade);
			}
			else
				RSFirewallHelper::grade('+10');
			
			return;
		}
		
		$response = '';
		// check every hash
		foreach ($hashes as $hash)
		{
			// check if there are any optional files and show them only once
			foreach ($optionals as $optional)
				if (substr($hash->file, 0, strlen($optional)) == $optional && !JFolder::exists(JPATH_SITE.DS.$optional))
				{
					$uninstalled = $session->get('integrity_uninstalled', array());
					if (!in_array($optional, $uninstalled))
					{
						$uninstalled[] = $optional;
						$session->set('integrity_uninstalled', $uninstalled);
						
						$response .= 'nochecku|'.$optional.'|'.JText::_('RSF_UNINSTALLED_HASH')."\n";
					}
					continue 2;
				}
				
			$file = realpath(JPATH_SITE.DS.$hash->file);
			$db_hash = $hash->hash;
			if (JFile::exists($file))
			{
				$curr_hash = md5_file($file);
				if ($db_hash != $curr_hash)
				{
					// hash is wrong
					$response .= 'nocheckw|'.$hash->file.'|'.JText::_('RSF_WRONG_HASH').'<a href="#" onclick="rsfirewall_fix_accept_change(this, \''.base64_encode($hash->file).'\'); return false;">'.JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/legacy/tick.png', JText::_('RSF_ACCEPT_CHANGE')).JText::_('RSF_ACCEPT_CHANGE').'</a>'."\n";
					
					$scrolling++;
					$wrong++;
				}
			}
			else
			{
				// hash is missing
				$response .= 'errorm|'.$hash->file.'|'.JText::_('RSF_MISSING_HASH').'<a href="#" onclick="rsfirewall_fix_accept_change(this, \''.base64_encode($hash->file).'\'); return false;">'.JHTML::_('image', 'administrator/components/com_rsfirewall/assets/images/legacy/tick.png', JText::_('RSF_ACCEPT_CHANGE')).JText::_('RSF_ACCEPT_CHANGE').'</a>'."\n";
				
				$scrolling++;
				$missing++;
			}
		}
		$session->set('integrity_wrong', $wrong);
		$session->set('integrity_missing', $missing);
		$session->set('integrity_scroll', $scrolling);
		$this->setResponse($response);
		
		$files = (int) $session->get('integrity_nr', 0);
		$files += count($hashes);
		$session->set('integrity_nr', $files);
	}
	
	function checkFolders()
	{
		$this->_db->setQuery("SELECT `path` FROM #__rsfirewall_ignored WHERE `type`='ignore_files_folders'");
		$this->ignore_files_folders = $this->_db->loadResultArray();
		
		$folder = JRequest::getVar('folder');
		if (empty($folder))
			$folder = JPATH_SITE;
		else
		{
			$folder = base64_decode($folder);
			$folder = JPath::clean($folder);
			if (!is_dir($folder))
				$folder = JPATH_SITE;
			if (strlen(JPATH_SITE) && strpos($folder, JPATH_SITE) !== 0)
				$folder = JPATH_SITE;
		}
		$this->parseFolders($folder);
		
		$session =& JFactory::getSession();
		
		$folders_wrong = (int) $session->get('folders_wrong', 0);
		if (!empty($this->folders))
		{
			$folders = (int) $session->get('folders_nr', 0);
			$folders += count($this->folders);
			$session->set('folders_nr', $folders);
			
			foreach ($this->folders as $folder)
			{
				$perm = substr(decoct(fileperms(JPATH_SITE.DS.$folder)),-3);
				if ($perm > 755)
				{
					$response = 'nocheckw*'.$folder.'*'.$perm."\n";
					$this->setResponse($response);
					$folders_wrong++;
				}
			}
			
			$session->set('folders_wrong', $folders_wrong);
			
			$last_folder = base64_encode(JPATH_SITE.DS.end($this->folders));
			$this->setResponse('|'.$last_folder);
		}
		else
		{
			$this->setResponse('STOP|OK');
			if ($folders_wrong > 12)
				$this->setResponse('|SCROLL');
			else
				$this->setResponse('|NOSCROLL');
				
			if (empty($folders_wrong))
				$this->setResponse('|'.JText::_('RSF_OK_FOLDER_PERMS'));
			else
				$this->setResponse('|WRONG');
			
			// grade
			if (!empty($folders_wrong))
			{
				$maxfolders = (int) $session->get('folders_nr', 0);
				$grade = 10 - ($folders_wrong * 10) / $maxfolders;
				RSFirewallHelper::grade($grade);
			}
			else
				RSFirewallHelper::grade('+10');
		}
		
		$this->setResponse('|');
		
		$files_wrong = (int) $session->get('files_wrong', 0);
		if (!empty($this->folders)) // need to rewrite this
		{
			$files = (int) $session->get('files_nr', 0);
			$files += count($this->files);
			$session->set('files_nr', $files);
			
			$patterns = '';
			foreach ($this->files as $file)
			{
				$perm = substr(decoct(fileperms(JPATH_SITE.DS.$file)),-3);
				if ($perm > 644)
				{
					$response = 'nocheckw*'.$file.'*'.$perm."\n";
					$this->setResponse($response);
					$files_wrong++;
				}
				$pattern = RSFirewallHelper::checkPatternsInFilename($file);
				if (!empty($pattern))
					$patterns .= 'nocheckw*'.$file.'*'.$pattern."\n";
			}
			
			$session->set('files_wrong', $files_wrong);
			$this->setResponse('|'.$patterns);
			$this->setResponse('|'.$folders);
			$this->setResponse('|'.$files);
		}
		else
		{
			$this->setResponse('STOP|OK|');
			if ($files_wrong > 12)
				$this->setResponse('SCROLL');
			else
				$this->setResponse('NOSCROLL');
				
			if (empty($files_wrong))
				$this->setResponse('|'.JText::_('RSF_OK_FILE_PERMS'));
			else
				$this->setResponse('|WRONG');
			
			// grade
			if (!empty($files_wrong))
			{
				$maxfiles = (int) $session->get('files_nr', 0);
				$grade = 10 - ($files_wrong * 10) / $maxfiles;
				RSFirewallHelper::grade($grade);
			}
			else
				RSFirewallHelper::grade('+10');
		}
	}
	
	function parseFolders($path, $remove=null)
	{
		if ($this->offset > RSFirewallHelper::getConfig('offset'))
			return;
		
		$folders = @JFolder::folders($path, '.', false, true);
		
		if (is_array($folders))
			foreach ($folders as $i => $folder)
			{
				$folder = str_replace(array('\\', '/'), DS, $folder);
				$folders[$i] = $folder;
				// Remove folders which could cause problems
				if (substr($folder, -2) == '/\\' || substr($folder, -2) == '\\/')
					unset($folders[$i]);
				// Remove ignored files and folders
				if (is_array($this->ignore_files_folders) && count($this->ignore_files_folders) && in_array($folder, $this->ignore_files_folders))
					unset($folders[$i]);
			}
		
		// the JFolder::folders method produces some inconsistencies so we need to use this
		sort($folders);
		
		// remove the current path
		if (!is_null($remove))
		{
			$i = array_search($remove, $folders);
			if ($i !== false)
				$folders = array_slice($folders, $i+1);
		}
		
		// the root has been completely checked
		if ($path == JPATH_SITE && empty($folders))
			return;
		
		// no folders left
		if (empty($folders))
		{
			// set to remove the current path
			$remove = $path;
			
			// up one level
			$path = explode(DS, $path);
			array_pop($path);
			$path = implode(DS, $path);
		}
		else
		{
			$remove = null;
			
			// set the next folder that needs to be scanned
			$path = reset($folders);
			
			// add to the folders list
			$this->folders[] = substr_replace($path, '', 0, strlen(JPATH_SITE.DS));
			
			// add to the files list
			$files = @JFolder::files($path, '.', false, true);
			foreach ($files as $file)
			{
				// Remove ignored files and folders
				if (is_array($this->ignore_files_folders) && count($this->ignore_files_folders) && in_array($file, $this->ignore_files_folders))
					continue;
					
				$this->files[] = substr_replace($file, '', 0, strlen(JPATH_SITE.DS));
			}
			
			$this->offset++;
		}
		// clear the memory
		unset($folders);
		
		$this->parseFolders($path, $remove);
	}
	
	function getPHPSettings()
	{
		$this->_wrong_php = false;
		
		$return = new stdClass();
		$return->register_globals = ini_get('register_globals') == 1 ? true : false;
		if ($return->register_globals)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+2');
			
		$return->safe_mode = ini_get('safe_mode') == 1 ? true : false;
		if ($return->safe_mode)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+2');
			
		$return->allow_url_fopen = ini_get('allow_url_fopen') == 1 ? true : false;
		if ($return->allow_url_fopen)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+5');
			
		$return->allow_url_include = ini_get('allow_url_include') == 1 ? true : false;
		if ($return->allow_url_include)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+5');
			
		$return->disable_functions = explode(',', ini_get('disable_functions'));
		$return->disable_functions_recommended = array('show_source', 'system', 'shell_exec', 'passthru', 'exec', 'phpinfo', 'popen', 'proc_open');
		$return->disable_functions_num = 0;
		foreach ($return->disable_functions as $i => $function)
		{
			$function = trim($function);
			if (in_array($function, $return->disable_functions_recommended))
				$return->disable_functions_num++;
			
			$return->disable_functions[$i] = $function;
		}
		$return->disable_functions_check = ($return->disable_functions_num == count($return->disable_functions_recommended));
		if (!$return->disable_functions_check)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+2');
		
		$return->open_basedir = ini_get('open_basedir');
		if (empty($return->open_basedir) || strlen($return->open_basedir) == 0)
			$this->_wrong_php = true;
		else
			RSFirewallHelper::grade('+2');
		
		return $return;
	}
	
	function getWrongPHP()
	{
		return $this->_wrong_php;
	}
	
	function getAdminActive()
	{
		$db =& JFactory::getDBO();
		if (RSFirewallHelper::isJ16())
		{
			$admin_groups = RSFirewallHelper::getAdminGroups();
			$db->setQuery("SELECT u.id FROM #__user_usergroup_map m LEFT JOIN #__users u ON (u.id=m.user_id) WHERE m.group_id IN (".implode(',', $admin_groups).") AND u.username='admin' AND u.block='0'");
		}
		else
			$db->setQuery("SELECT `id` FROM #__users WHERE `block`='0' AND `username`='admin' AND `gid` > 22");
			
		$valid = $db->loadResult() ? true : false;
		
		if (!$valid)
			RSFirewallHelper::grade('+5');
		
		return $valid;
	}
	
	function getWeakPasswords()
	{
		$db =& JFactory::getDBO();
		jimport('joomla.user.helper');
		$return = array();
		$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_rsfirewall'.DS.'assets'.DS.'dictionary'.DS.'passwords.txt';
		$passwords = file($file);
		
		$users = RSFirewallHelper::getAdminUsers();
		foreach ($users as $user)
		{
			$parts	= explode(':', $user->password);
			$crypt	= $parts[0];
			$salt	= @$parts[1];
			foreach ($passwords as $password)
			{
				$password = trim($password);
				$testcrypt = JUserHelper::getCryptedPassword($password, $salt);
			
				if ($crypt == $testcrypt)
				{
					$r = new stdClass();
					$r->username = $user->username;
					$r->password = $password;
					$return[] = $r;
				}
			}
		}
		
		if (empty($return))
			RSFirewallHelper::grade('+10');
		
		return $return;
	}
	
	function getJUMIVulnerable()
	{
		$file = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_jumi'.DS.'install.package.php';
		
		if (!JFile::exists($file))
			return null;
		
		$contents = JFile::read($file);
		
		if (strpos($contents, 'eval(gzinflate(base64_decode') !== false)
		{
			RSFirewallHelper::grade('-20');
			return true;
		}
		
		$files = array(JPATH_SITE.DS.'tmp'.DS.'.config.php', JPATH_ADMINISTRATOR.DS.'modules'.DS.'mod_mainmenu'.DS.'tmpl'.DS.'.config.php', JPATH_SITE.DS.'modules'.DS.'mod_mainmenu'.DS.'tmpl'.DS.'.config.php');
		foreach ($files as $file)
			if (JFile::exists($file))
			{
				RSFirewallHelper::grade('-20');
				return true;
			}
			
		return false;
	}
	
	function getJoomlaConfiguration()
	{
		$return = new stdClass();
		$return->sef = false;
		$return->htaccess = false;
		$return->lifetime = false;
		$return->ftp_pass = false;
		
		$return->wrong = false;
		
		// Joomla! SEF
		$config = new JConfig();
		if ($config->sef)
			$return->sef = true;
		// 3rd Party Sef
		elseif (class_exists('shRouter'))
		{
			$shConfig = shRouter::shGetConfig();
			if ($shConfig->Enabled)
				$return->sef = true;
		}
		
		if ($return->sef)
			RSFirewallHelper::grade('+3');
		else
			$return->wrong = true;
		
		// .htaccess
		if (file_exists(JPATH_SITE.DS.'.htaccess'))
		{
			$return->htaccess = true;
			RSFirewallHelper::grade('+5');
		}
		else
			$return->wrong = true;
		
		$return->lifetime = $config->lifetime;
		if ($return->lifetime > 15)
			$return->wrong = true;
		else
			RSFirewallHelper::grade('+3');
			
		if (strlen($config->ftp_pass) == 0)
		{
			$return->ftp_pass = true;
			RSFirewallHelper::grade('+5');
		}
		else
			$return->wrong = true;
		
		return $return;
	}
	
	function getTempOutsideResult()
	{
		$config =& JFactory::getConfig();
		$root = realpath($_SERVER['DOCUMENT_ROOT']);
		
	 	$tmp_path = $config->getValue('config.tmp_path');
		$valid = strpos($tmp_path, $root) === false ? true : false;
		
		if ($valid)
			RSFirewallHelper::grade('+3');
		
		return $valid;
	}
	
	function getLogOutsideResult()
	{
		$config =& JFactory::getConfig();
		$root = realpath($_SERVER['DOCUMENT_ROOT']);
		
		$log_path = $config->getValue('config.log_path');
		$valid = strpos($log_path, $root) === false ? true : false;
		
		if ($valid)
			RSFirewallHelper::grade('+3');
		
		return $valid;
	}
	
	function getTempFilesResult()
	{
		$config =& JFactory::getConfig();
	 	$tmp_path = $config->getValue('config.tmp_path');
		$files = @JFolder::files($tmp_path, '', true, true, array('index.html'));
		$count = is_array($files) ? count($files) : 0;
		
		if (!$count)
			RSFirewallHelper::grade('+3');
		
		return $count;
	}
	
	function getConfigurationResult()
	{
		$config_result = RSFirewallHelper::checkJavascriptPatterns(JPATH_CONFIGURATION.DS.'configuration.php');
		if (empty($config_result))
		{
			$valid = true;
			RSFirewallHelper::grade('+10');
		}
		else
		{
			$this->_file_errors['configuration'][] = $config_result;
			$valid = false;
		}
		
		return $valid;
	}
	
	function getConfigurationErrors()
	{
		if (isset($this->_file_errors['configuration']))
			return $this->_file_errors['configuration'];
		else
			return array();
	}
	
	function getConfigurationOutsideResult()
	{
		$root = realpath($_SERVER['DOCUMENT_ROOT']);
		$config = realpath(JPATH_CONFIGURATION);
		
		// haystack, needle
		if (strpos($config, $root) !== false)
			$valid = false;
		else
		{
			$valid = true;
			RSFirewallHelper::grade('+5');
		}
		
		return $valid;
	}
	
	function checkMisc()
	{
		if (RSFirewallHelper::getConfig('lockdown'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('master_password_enabled') && RSFirewallHelper::getConfig('master_password'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('backend_password_enabled') && RSFirewallHelper::getConfig('backend_password'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('active_scanner_status'))
			RSFirewallHelper::grade('+10');
		if (RSFirewallHelper::getConfig('verify_dos'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_emails'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_generator'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_sql'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_php'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_js'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_multiple_exts'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('monitor_core'))
			RSFirewallHelper::grade('+5');
		if (RSFirewallHelper::getConfig('verify_upload'))
			RSFirewallHelper::grade('+5');
	}
	
	function getGrade()
	{
		RSFirewallHelper::saveGrade();
		
		$grade = RSFirewallHelper::convertGrade(RSFirewallHelper::getGrade());
		if (empty($grade))
			$grade = '0.0';
			
		if ($grade >= 75)
			$img = 'administrator/components/com_rsfirewall/assets/images/grade-green.jpg';
		else
			$img = 'administrator/components/com_rsfirewall/assets/images/grade-blue.jpg';
			
		$response = '<div id="cpanel"><div style="float: left"><div class="icon"><a href="javascript: void(0)" class="rsfirewall_grade_container"><span class="rsfirewall_grade">'.$grade.'</span>'.JHTML::_('image', $img, JText::_('RSF_GRADE')).'<span>'.JText::_('RSF_GRADE').'</span></a></div></div></div>';
		$this->setResponse($response);
	}
}
?>