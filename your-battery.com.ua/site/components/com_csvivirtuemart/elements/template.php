<?php
/**
* Element selector for menu entry
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: template.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

class JElementTemplate extends JElement {
	
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	 */
	var	$_name = 'Export template';
	
	function fetchElement($name, $value, $node, $control_name) {
		$db = JFactory::getDBO();
		$q = "SELECT template_id, template_name 
			FROM #__csvivirtuemart_templates
			WHERE template_type LIKE '%export'
			AND export_frontend = 1";
		$db->setQuery($q);
		$templates = $db->loadObjectList();
		return JHTML::_('select.genericlist', $templates, $control_name.'['.$name.']', '', 'template_id', 'template_name', $value, $control_name.$name);
	}
}
