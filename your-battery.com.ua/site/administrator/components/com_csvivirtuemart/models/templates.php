<?php
/**
* Templates model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templates.php 1118 2010-01-04 11:39:59Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Templates Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelTemplates extends JModel {
	
	/** @var int contains the table ID */
	private $_id = null;
	/** @var string table name */
	private $_tablename = 'csvivirtuemart_templates';
	
	/**
	* Items total
	* @var integer
	 */
	var $_total = null;
	
	/**
	* Pagination object
	* @var object
	 */
	var $_pagination = null;
	
	/**
	* Constructor
	* @todo maintain the search selection and last chosen page
	 */
	public function __construct() {
		parent::__construct();
		
		$mainframe = Jfactory::getApplication();
		$option	= JRequest::getCmd('option');
		
		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');
		
		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit)* $limit) : 0);
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}
	
	function getData() {
        // if data hasn't already been obtained, load it
        if (empty($this->_data)) {
            $query = $this->_buildQuery();
            $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit')); 
        }
        return $this->_data;
    }
    
    function getTotal() {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
            $this->_total = $this->_getListCount($query);    
        }
        return $this->_total;
    }
    
    function getPagination() {
        // Load the content if it doesn't already exist
        if (empty($this->_pagination)) {
            jimport('joomla.html.pagination');
            $this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
        }
        return $this->_pagination;
    }
    
	
	/**
	* Create the query
	 */
	private function _buildQuery() {
		$mainframe = Jfactory::getApplication();
		$db = JFactory::getDBO();
		$filters = array();
		
		/* Load filters */
		$filter = JRequest::getWord('templatetype', false);
		$filter_templates = JRequest::getString('filter_templates', false);
		$filter_order		= $mainframe->getUserStateFromRequest('templateslist.filter_order',		'filter_order',		'template_name',	'cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest('templateslist.filter_order_Dir',	'filter_order_Dir',	'',	'word');
		$filter_state		= $mainframe->getUserStateFromRequest('templateslist.filter_state',		'filter_state',		'',	'word');
		
		$q = "SELECT template_id, template_name, template_type
			FROM #__csvivirtuemart_templates";
			
		if ($filter) $filters[] = "template_type LIKE '%".$filter."'";
		if ($filter_templates) $filters[] = "template_name LIKE ".$db->Quote('%'.$filter_templates.'%');
		if (count($filters) > 0) $q .= " WHERE ".implode(' AND ', $filters);
		if ($filter_order) $q .= " ORDER BY ".$filter_order.' '.$filter_order_Dir;
		
		return $q;
	}
	
	/**
	* Set the template ID
	 */
	function setTemplateId($template_id) {
		if (is_numeric($template_id)) $this->_id = $template_id;
		/* String, so search on template name */
		else {
			$db = JFactory::getDBO();
			$q = "SELECT template_id FROM #__csvivirtuemart_templates WHERE template_name = ".$db->Quote($template_id);
			$db->setQuery($q);
			$this->_id = $db->loadResult();
		}
	}
	
	/**
	* Get an empty template model
	 */
	function getEmptyTemplate() {
		return $this->getTable($this->_tablename);
	}
	
	/**
	* Retrieves a list of templates
	 */
	function getTemplatesListExport() {
		$db = JFactory::getDBO();
		$q = "SELECT *
			FROM #__csvivirtuemart_templates
			WHERE template_type LIKE ".$db->Quote('%export%')."
			ORDER BY template_name";
		$db->setQuery($q);
		
		$templates = $db->loadObjectList();
		if (count($templates) > 0) {
			if (isset($templates[0]->template_id)) {
				foreach ($templates as $key => $template) {
					if (isset($template->template_id)) {
						$this->_id = $template->template_id;
						$templates[$key]->numberoffields = $this->getNumberOfFields();
					}
				}
			}
			else {
				$templates = array();
				JError::raiseWarning(0, JText::_('DATABASE_CONFIGURATION_ERROR'));
			}
		}
		return $templates;
	}
	
	/**
	* Retrieves a list of templates
	 */
	function getTemplatesListImport() {
		$db = JFactory::getDBO();
		$q = "SELECT *
			FROM #__csvivirtuemart_templates
			WHERE template_type LIKE ".$db->Quote('%import%')."
			ORDER BY template_name";
		$db->setQuery($q);
		
		$templates = $db->loadObjectList();
		if (count($templates) > 0) {
			if (isset($templates[0]->template_id)) {
				foreach ($templates as $key => $template) {
					if (isset($template->template_id)) {
						$this->_id = $template->template_id;
						$templates[$key]->numberoffields = $this->getNumberOfFields();
					}
				}
			}
			else {
				$templates = array();
				JError::raiseWarning(0, JText::_('DATABASE_CONFIGURATION_ERROR'));
			}
		}
		return $templates;
	}
	
	/**
	* Returns the number of fields associated with a template
	*
	* @param $template_id integer The id of the template
	 */
	public function getNumberOfFields() {
		$db = JFactory::getDBO();
		
		$q = "SELECT COUNT(id) AS numberoffields FROM #__csvivirtuemart_template_fields ";
		$q .= "WHERE field_template_id = ".$this->_id." ";
		$q .= "AND published = 1";
		$db->setQuery($q);
		
		return $db->loadResult();
	}
	
	/**
	* Get the template details
	*
	* Retrieves the template details from the csvi_templates table. If the
	* template id is 0, it will automatically retrieve the template details
	* for the template with the lowest ID in the database
	*
	* @see self::GetFirstTemplateId();
	* @param $templateid integer Template ID to retrieve
	 */
	function getTemplate() {
		$row = $this->getTable($this->_tablename);
		
		if ($this->_id == 0) {
			$this_id = $this->GetFirstTemplateId();
		}
		$row->load($this->_id);
		
		return $row;
	}
	
	/**
	* Get the name of a template
	*
	* @param $templateid integer Template ID to retrieve
	 */
	public function getTemplateName() {
		$db = JFactory::getDBO();
		$q = "SELECT template_name FROM #__csvivirtuemart_templates
			WHERE template_id = ".$this->_id;
		$db->setQuery($q);
		return $db->loadResult();
	}
	
	/**
	* Updates a template with the new user settings
	*
	* @param $template object contains the new template settings
	 */
	function getSaveTemplate() {
		global $mainframe;
		$row = $this->getTable($this->_tablename);
		$post = JRequest::get('post', 4);
		/* Fix the template type */
		$post['template_type'] = $post['template_type_'.$post['type']];
		
		/* Get the posted data */
		if (!$row->bind($post)) {
			$mainframe->enqueueMessage(JText::_('There was a problem binding the data'), 'error');
			return false;
		}
		
		/* Fix the manufacturer to be a string */
		if (is_array($row->manufacturer)) {
			if (in_array("0", $row->manufacturer)) $row->manufacturer = '0';
			else $row->manufacturer = implode(',', $row->manufacturer);
		}
		
		/* Pre-save checks */
		if (!$row->check()) {
		 $mainframe->enqueueMessage(JText::_('There was a problem checking the data'), 'error');
		 return false;
		}
		
		/* Save the changes */
		if (!$row->store()) {
			$mainframe->enqueueMessage(JText::_('There was a problem storing the data:').' '.$row->getError(), 'error');
			return false;
		}
		return $row;
	}
	
	/**
	* Clones a template and the associated fields
	*
	* @param $templateid integer Template ID to retrieve
	*/	
	function getCloneTemplate() {
		global $mainframe;
		
		/* Load the current template */
		$row = $this->getTable($this->_tablename);
		$row->load($this->_id);
		
		/* Save it as a new template */
		$row->template_id = 0;
		$row->template_name .= '_'.date('Ymd_His', time());
		
		/* Pre-save checks */
		if (!$row->check()) {
		 $mainframe->enqueueMessage(JText::_('There was a problem checking the data'), 'error');
		 return false;
		}
		
		/* Save the changes */
		if (!$row->store()) {
			$mainframe->enqueueMessage(JText::_('Not able to clone template:').' '.$row->getError(), 'error');
			return false;
		}
		else {
			$mainframe->enqueueMessage(JText::_('Template has been cloned'));
			$db = JFactory::getDBO();
			/* Now duplicate the fields */
			$q = "INSERT INTO `#__csvivirtuemart_template_fields` (
			`field_template_id` ,
			`field_name` ,
			`field_column_header` ,
			`field_default_value` ,
			`field_order`,
			`published`
			)
			(SELECT ".$row->template_id." , 
				`field_name` ,
				`field_column_header` ,
				`field_default_value` ,
				`field_order`,
				`published`
				FROM #__csvivirtuemart_template_fields
				WHERE `field_template_id`=".$this->_id."
			)";
			$db->setQuery($q);
			if ($db->query()) {
				$mainframe->enqueueMessage(JText::_('Template fields have been cloned'));
				return true;
			}
			else {
				$mainframe->enqueueMessage(JText::_('Not able to clone template fields').'<br  />'.$q.'<br />'.$db->getErrorMsg(), 'error');
				return false;
			}
		}
	}
	
	/**
	* Delete selected template
	*
	* @param $template_id integer The id of the template
	 */
	function getDeleteTemplate() {
		global $mainframe;
		
		/* Delete the current template */
		$row = $this->getTable($this->_tablename);
		if ($row->delete($this->_id)) {
			$mainframe->enqueueMessage(JText::_('Template has been deleted'));
			$this->setTemplateId(0);
			/* Delete the fields related to the template */
			$db =& JFactory::getDBO();
			$q = "DELETE FROM #__csvivirtuemart_template_fields WHERE field_template_id = ".$this->_id;
			$db->setQuery($q);
			if ($db->query()) $mainframe->enqueueMessage(JText::_('Template fields have been deleted'));
			else $mainframe->enqueueMessage(JText::_('Template fields could not be deleted').$db->getErrorMsg());
		}
		else {
			$mainframe->enqueueMessage(JText::_('Could not delete template:').' '.$row->getError());
		}
	}
	
	/**
	* Retrieve fields for a template
	*
	* Retrieves all fields for a template or retrieves a limited number of
	* fields if set
	*
	* @param $template_id integer The id of the template
	* @param $filter string The string to filter the template names on
	 */
	public function GetFields($template_id, $filter) {
		$db = JFactory::getDBO();
		$q = "SELECT * FROM #__csvivirtuemart_template_fields 
			WHERE field_template_id = ".$template_id." ";
			if ($filter) $q .= "AND field_name LIKE '%".$filter."%' ";
		$q .= "ORDER BY field_order, field_name";
		
		$db->setQuery($q);
		
		return $db->loadObjectList();
	}
	
	/**
	* Get the first template id
	 */
	private function GetFirstTemplateId() {
		$db = JFactory::getDBO();
		$q = 'SELECT MIN(template_id) FROM #__csvivirtuemart_templates';
		$db->setQuery($q);
		
		return $db->loadResult();
	}
	
	/**
	* Get all the shopper groups
	 */
	function getShopperGroups() {
		$db = JFactory::getDBO();
		$q = "SELECT shopper_group_id, shopper_group_name FROM #__vm_shopper_group";
		$db->setQuery($q);
		return $db->loadObjectList();
	}
	
	/**
	* Get all the manufacturers
	 */
	function getManufacturers() {
		$db = JFactory::getDBO();
		$q = "SELECT manufacturer_id, mf_name FROM #__vm_manufacturer ORDER BY mf_name";
		$db->setQuery($q);
		return $db->loadObjectList();
	}
	
	/**
	* Get all the manufacturers
	 */
	function getTemplateTypes($type=false) {
		$db = JFactory::getDBO();
		$q = "SELECT template_type_name AS name, template_type_name AS value 
			FROM #__csvivirtuemart_template_types ";
		$q .= ($type) ? "WHERE template_type = ".$db->Quote($type) : "";
		$q .= " ORDER BY template_type_name";
		$db->setQuery($q);
		$types = $db->loadObjectList();
		
		/* Translate the strings */
		foreach ($types as $key => $type) {
			$type->value = JText::_($type->value);
			$types[$key] = $type;
		}
		return $types;
	}
	
	/**
	* Get the next template field number
	 */
	 public function getNextFieldNumber() {
	 	$db = JFactory::getDBO();
	 	$q = "SELECT IF (ISNULL(MAX(field_order)), 1, MAX(field_order)+1)
	 		FROM #__csvivirtuemart_template_fields 
	 		WHERE field_template_id = ".$this->_id;
	 	$db->setQuery($q);
	 	return $db->loadResult();
	 }
	 
	 /**
	* Get a list of possible VM Item IDs
	 */
	 public function getVmItemids() {
	 	$db = JFactory::getDBO();
	 	$q = "SELECT id AS value, name AS text
	 		FROM #__menu
	 		WHERE link LIKE '%com_virtuemart%'";
	 	$db->setQuery($q);
	 	return $db->loadObjectList();
	 }
}
?>