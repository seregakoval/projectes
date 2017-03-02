<?php
/**
* Replacement model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: replacement.php 1139 2010-01-28 18:34:11Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Replacement Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelReplacement extends JModel {
	
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
		$db = JFactory::getDBO();
		$filter = JRequest::getVar('filterfield', false);
		/* Get all records */
		$q = "SELECT *
			FROM #__csvivirtuemart_replacements";
		if ($filter) $q .= " WHERE (old_value LIKE ".$db->Quote('%'.$filter.'%')." OR new_value LIKE ".$db->Quote('%'.$filter.'%').")";
		return $q;
	}
	
	/**
	* Adds a new replacement to the database
	 */
	public function getAddReplacement() {
		$row = $this->getTable('csvivirtuemart_replacements');
		$row->old_value = JRequest::getVar('_old_value', null, 'default', 'none', 2);
		$row->new_value = JRequest::getVar('_new_value', null, 'default', 'none', 2);
		$row->regex = JRequest::getInt('_regex', null);
		$row->template_id = JRequest::getInt('_template_id', null);
		$row->field_id = JRequest::getInt('_field_id', null);
		$row->published = 1;
		
	 	return ($row->store());
	}
	
	/**
	* Saves the list of replacements
	*/
	public function getSaveReplacement() {
	 	$mainframe = JFactory::getApplication('administrator');
	 	$post = JRequest::get('post', 2);
	 	$row = $this->getTable('csvivirtuemart_replacements');
	 	$saved = 0;
	 	$notsaved = 0;
	 	foreach ($post['field'] as $id => $field) {
	 		if (is_int($id)) {
				$row->load($id);
				$row->bind($field);
				if ($row->store()) {
					$saved++;
				}
				else $notsaved++;
				$row->reset();
			}
	 	}
	 	if ($saved > 0) {
			$mainframe->enqueueMessage(str_replace('{X}', $saved, JText::_('SAVE_X_REPLACEMENT_DATA')));
		}
		if ($notsaved > 0) {
			$mainframe->enqueueMessage(str_replace('{X}', $notsaved, JText::_('CANNOT_SAVE_X_REPLACEMENT_DATA')), 'error');
		}
	}
	
	/**
	* Adds a new replacement to the database
	*/
	public function getRemoveReplacement() {
		$mainframe = Jfactory::getApplication('administrator');
		$cids = JRequest::getVar('cid');
		
		/* Make it an array */
		if (!is_array($cids)) settype($cids, 'array');
		
		/* Update the database */
		$row = $this->getTable('csvivirtuemart_replacements');
		$deleted = 0;
		$notdeleted = 0;
		foreach ($cids as $key => $id) {
			if (!$row->delete($id)) {
				$notdeleted++;
			}
			else $deleted++;
		}
		if ($deleted > 0) {
			if (JRequest::getVar('format') == 'json') return array('result' => 1);
			$mainframe->enqueueMessage(str_replace('{X}', $deleted, JText::_('DELETE_X_REPLACEMENT_DATA')));
		}
		if ($notdeleted > 0) {
			if (JRequest::getVar('format') == 'json') return array('result' => 0);
			$mainframe->enqueueMessage(str_replace('{X}', $notdeleted, JText::_('CANNOT_DELETE_X_REPLACEMENT_DATA')), 'error');
		}
	}
	
	/**
	* Switch the published state
	*
	* @author RolandD
	*/
	public function getSwitchPublish() {
	 	$row = $this->getTable('csvivirtuemart_replacements');
	 	$row->load(JRequest::getInt('id'));
	 	$row->published = ($row->published == 1) ? 0 : 1;
	 	$row->store();
	 	if ($row->published == 1) return array('state' => 'published', "result" => 1);
	 	else if ($row->published == 0) return array('state' => 'unpublished', "result" => 0);
	 }
	 
	/**
	* Load the replacements to be used for export
	*
	* @author RolandD
	* @param int $field_id the ID of the field to replace
	* @return array contains arrays with all replacement values 
	*/
	public function getExportReplacements($field_id) {
	  	 $db = JFactory::getDBO();
	  	 $template = JRequest::getVar('template');
	  	 $andtemplate = " AND template_id = ".$template->template_id." AND field_id = ".$field_id;
	  	 $q = "SELECT old_value 
	  	 	FROM #__csvivirtuemart_replacements 
	  	 	WHERE regex = 0
	  	 	AND published = 1"
	  	 	.$andtemplate;
	  	 $db->setQuery($q);
	  	 $findtext = $db->loadResultArray();
	  	 
	  	 $q = "SELECT old_value FROM #__csvivirtuemart_replacements 
	  	 	WHERE regex = 1
	  	 	AND published = 1"
	  	 	.$andtemplate;
	  	 $db->setQuery($q);
	  	 $findregex = $db->loadResultArray();
	  	 
	  	 $q = "SELECT new_value FROM #__csvivirtuemart_replacements 
	  	 	WHERE regex = 0
	  	 	AND published = 1"
	  	 	.$andtemplate;
	  	 $db->setQuery($q);
	  	 $replacetext = $db->loadResultArray();
	  	 
	  	 $q = "SELECT new_value FROM #__csvivirtuemart_replacements 
	  	 	WHERE regex = 1
	  	 	AND published = 1"
	  	 	.$andtemplate;
	  	 $db->setQuery($q);
	  	 $replaceregex = $db->loadResultArray();
	  	 
	  	 return array('findtext' => $findtext, 'replacetext' => $replacetext, 'findregex' => $findregex, 'replaceregex' => $replaceregex);
	 }
	 
	/**
	* Load a list of fields for the selected template
	*
	* @author RolandD
	* @param int $template_id the ID of the template to get the fields for
	*/
	public function getLoadFields($template_id=false) {
	 	$db = JFactory::getDBO();
	 	if (!$template_id) $template_id = JRequest::getInt('template_id');
	 	$q = "SELECT CONCAT(field_order, '. ', field_name, ' :: ', field_column_header) AS text, id AS value
	 		FROM #__csvivirtuemart_template_fields
	 		WHERE field_template_id = ".$template_id."
	 		ORDER BY field_order";
	 	$db->setQuery($q);
	 	$fields = $db->loadAssocList();
	 	
	 	return $fields;
	 }
}
?>