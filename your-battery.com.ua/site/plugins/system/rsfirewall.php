<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.plugin.plugin');
jimport('joomla.filesystem.file');

$helper = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_rsfirewall'.DS.'helpers'.DS.'rsfirewall.php';
if (JFile::exists($helper))
	require_once($helper);

class plgSystemRSFirewall extends JPlugin {
	
	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @since 1.5
	 */
	 
	var $_mails; 
	
	function plgSystemRSFirewall(&$subject, $config) {
		parent::__construct($subject, $config);
		
		if (class_exists('RSFirewallHelper'))
			RSFirewallHelper::readConfig();
		else
			JError::raiseWarning(500, JText::_('RSF_WARNING_HELPER_MISSING'));
	}
	
	function onAfterInitialise()
	{
		if (!class_exists('RSFirewallHelper'))
			return;
			
		$this->loadLanguage('com_rsfirewall', JPATH_ADMINISTRATOR);
			
		RSFirewallHelper::checkBlacklist();
		RSFirewallHelper::checkAgents();
		RSFirewallHelper::checkDoS();
		
		RSFirewallHelper::checkOption();
		RSFirewallHelper::checkActiveScannerInjections();
		RSFirewallHelper::checkLockdown();
		
		RSFirewallHelper::checkBackendPassword();
		RSFirewallHelper::checkBackendUser();
		RSFirewallHelper::checkActiveScanner();
	}
	
	function onAfterRoute()
	{
		if (!class_exists('RSFirewallHelper'))
			return;
			
		RSFirewallHelper::checkLoginAttempts();
		RSFirewallHelper::removeGenerator();
	}
	
	function onAfterRender()
	{
		if (!class_exists('RSFirewallHelper'))
			return;
			
		$mainframe =& JFactory::getApplication();
		
		RSFirewallHelper::showPasswordStrength();
		RSFirewallHelper::showCaptcha();
		if ($mainframe->isAdmin()) return;
		if (!RSFirewallHelper::getConfig('active_scanner_status')) return;
		if (!RSFirewallHelper::getConfig('verify_emails')) return;
		
		$mails = array();
		$text =& JResponse::getBody();
		
		if (JString::strpos($text, '{emailcloak=off}') !== false)
		{
			$text = JString::str_ireplace('{emailcloak=off}', '', $text);
			JResponse::setBody($text);
			return true;
		}
		
		// performance check
		if (JString::strpos($text, '@') === false)
			return true;
		
		// any@email.address.com
		$searchEmail = '([\w\.\-]+\@(?:[a-z0-9\.\-]+\.)+(?:[a-z0-9\-]{2,4}))';
		// any@email.address.com?subject=anyText
		$searchEmailLink = $searchEmail . '([?&][\x20-\x7f][^"<>]+)';
		// anyText
		$searchText = '([\x20-\x7f][^<>]+)';
		
		$found = false;
		
		/*
		 * Search for derivatives of link code <a href="mailto:email@amail.com"
		 * >email@amail.com</a>
		 */
		$pattern = $this->plgSystemRSFirewall_searchPattern($searchEmail, $searchEmail);
		while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
		{
			$mail = $regs[1][0];
			$mailText = $regs[2][0];
			$params = array('mail' => $mail, 'mailText' => $mailText);
			
			$replacement = $this->plgSystemRSFirewall_getReplacement($params);
			$text = substr_replace($text, $replacement, $regs[0][1], strlen($regs[0][0]));
			$found = true;
		}

		/*
		 * Search for derivatives of link code <a href="mailto:email@amail.com">
		 * anytext</a>
		 */
		$pattern = $this->plgSystemRSFirewall_searchPattern($searchEmail, $searchText);
		while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
		{
			$mail = $regs[1][0];
			$mailText = $regs[2][0];
			$params = array('mail' => $mail, 'mailText' => $mailText);
			
			$replacement = $this->plgSystemRSFirewall_getReplacement($params);
			$text = substr_replace($text, $replacement, $regs[0][1], strlen($regs[0][0]));
			$found = true;
		}

		/*
		 * Search for derivatives of link code <a href="mailto:email@amail.com?
		 * subject=Text">email@amail.com</a>
		 */
		$pattern = $this->plgSystemRSFirewall_searchPattern($searchEmailLink, $searchEmail);
		while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
		{
			$mail = $regs[1][0] . $regs[2][0];
			$mail = str_replace( '&amp;', '&', $mail );
			$mailText = $regs[3][0];
			$params = array('mail' => $mail, 'mailText' => $mailText);

			$replacement = $this->plgSystemRSFirewall_getReplacement($params);
			$text = substr_replace($text, $replacement, $regs[0][1], strlen($regs[0][0]));
			$found = true;
		}

		/*
		 * Search for derivatives of link code <a href="mailto:email@amail.com?
		 * subject=Text">anytext</a>
		 */
		$pattern = $this->plgSystemRSFirewall_searchPattern($searchEmailLink, $searchText);
		while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
		{
			$mail = $regs[1][0] . $regs[2][0];
			$mail = str_replace('&amp;', '&', $mail);
			$mailText = $regs[3][0];
			$params = array('mail' => $mail, 'mailText' => $mailText);

			$replacement = $this->plgSystemRSFirewall_getReplacement($params);
			$text = substr_replace($text, $replacement, $regs[0][1], strlen($regs[0][0]));
			$found = true;
		}

		// Search for plain text email@amail.com
		$pattern = '~' . $searchEmail . '([^a-z0-9]|$)~i';
		while (preg_match($pattern, $text, $regs, PREG_OFFSET_CAPTURE))
		{
			$mail = $regs[1][0];
			$params = array('mail' => $mail);
			
			$replacement = $this->plgSystemRSFirewall_getReplacement($params);
			$text = substr_replace($text, $replacement, $regs[1][1], strlen($mail));
			$found = true;
		}
		
		if ($found)
		{
			$string  = '';
			$string .= "\r\n".'<script type="text/javascript">function rsfirewall_mail(what){';
			foreach ($this->_mails as $mail)
				$string .= "\nif (what == 'rsfirewall_".$mail['id']."')"."\ndocument.getElementById(what).src = '".JRoute::_('index.php?option=com_rsfirewall&task=mail&string='.$mail['encoded_mail'])."';\r\n";
			$string .= '}</script>';
			$text = str_replace('</body>', $string.'</body>', $text);
		}
		
		JResponse::setBody($text);
		return true;
	}
	
	function plgSystemRSFirewall_searchPattern ($link, $text)
	{
		$pattern = '~(?:<a [\w "\'=\@\.\-]*href\s*=\s*"mailto:'
		. $link . '"[\w "\'=\@\.\-]*)>' . $text . '</a>~i';

		return $pattern;
	}
	
	function plgSystemRSFirewall_getReplacement($params=array())
	{
		$_mail = array();
		$id = uniqid('');
		$_mail['id'] = $id;
		if (!empty($params['mail']))
		{
			$mail = $params['mail'];
			$encoded_mail = base64_encode($mail);
			$_mail['encoded_mail'] = $encoded_mail;
			$_mail['mail'] = $mail;
			$replacement = '<img src="'.JRoute::_('index.php?option=com_rsfirewall&task=cloak&string='.$encoded_mail).'" style="cursor: pointer; vertical-align: middle" alt="" onclick="rsfirewall_mail(\'rsfirewall_'.$id.'\')" />';
		}
		if (!empty($params['mailText']))
		{
			$mailText = $params['mailText'];
			$_mail['mailText'] = $mailText;
			$replacement = '<a href="javascript: void(0)" onclick="rsfirewall_mail(\'rsfirewall_'.$id.'\')">'.$mailText.'</a>';
		}
		$this->_mails[] = $_mail;
		
		$replacement .= '<iframe src="" style="display: none; position: absolute; left: -1000px; top: -1000px;" width="0%" height="0%" id="rsfirewall_'.$id.'"></iframe>';
		return $replacement;
	}
}