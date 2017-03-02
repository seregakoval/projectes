<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class RSFirewallModelDBCheck extends JModel
{	
	function __construct()
	{
		parent::__construct();
		
		$this->_db =& JFactory::getDBO();
	}
	
	function getTables()
	{
		$this->_db->setQuery("SHOW TABLE STATUS");
		return $this->_db->loadObjectList();
	}
}
?>