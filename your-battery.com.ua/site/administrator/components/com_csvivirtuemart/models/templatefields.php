<?php
/**
* Templatefields model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templatefields.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Replacement Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelTemplatefields extends JModel {
	
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
	
	
	 function __construct() {
		parent::__construct();
		
		global $mainframe, $option;
		
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
		$template_id = JRequest::getInt('template_id', false);
		$filter = JRequest::getVar('filterfield', false);
		/* Get all records */
		$q = "SELECT *
			FROM #__csvivirtuemart_template_fields";
		if ($template_id) $q .= " WHERE field_template_id = ".$template_id;
		if ($filter) {
			if ($template_id) $q .= " AND";
			else $q .= " WHERE";
			$q .= " field_name LIKE ".$db->Quote('%'.$filter.'%').")";
		}
		return $q;
	}
	
	/**
	* Switch the published state
	 */
	public function getSwitchPublish() {
		$row = $this->getTable('csvivirtuemart_template_fields');
		$row->load(JRequest::getInt('id'));
		$row->published = ($row->published == 1) ? 0 : 1;
		$row->store();
		if ($row->published == 1) return array('state' => 'published', "result" => 1);
		else if ($row->published == 0) return array('state' => 'unpublished', "result" => 0);
	}
	
	/**
	* Publish fields
	*
	* @param $cids array Array of field IDs to either publish or unpublish
	* @param $task string String which tells to publish or unpublis the ids
	* @return bool true|false true if all fields are published|false if there is an error
	 */
	function getSwitchPublishFields() {
		$db = JFactory::getDBO();
		$cids = JRequest::getVar('cid');
		$task = JRequest::getVar('task');
		
		if (is_array($cids)) {
			$ids = '';
			$q = "UPDATE #__csvivirtuemart_template_fields
				SET published = ";
			if ($task == 'publish') $q .= "1 ";
			else if ($task == 'unpublish') $q .= "0 ";
			$q .= "WHERE id IN (";
			foreach ($cids as $key => $field_id) {
				$ids .= $field_id.', ';
			}
			$q .= substr($ids,0, -2).")";
			$db->setQuery($q);
			if ($db->query()) return true;
			else return false;
		}
		else return false;
	}
	
	/**
	* Save all input fields from the fields table
	*
	* @param $template_id integer The id of the template
	* @param $fields array Holds all fields to update
	 */
	function getSaveFieldsTable() {
		$mainframe = Jfactory::getApplication('administrator');
		$db = JFactory::getDBO();
		$fields = JRequest::getVar('field');
		$saved = 0;
		$notsaved = 0;
		if (is_array($fields)) {
			/* The {fill} is used for adding new fields dynamically */
			unset($fields['{fill}']);
			$row = $this->getTable('csvivirtuemart_template_fields');
			foreach ($fields as $key => $field) {
				/* Load the field */
				$row->load($field['_id']);
				
				/* Setup the new values */
				$newvalues = array();
				$newvalues['field_name'] = $db->getEscaped($field['_field_name']);
				if (isset($field['_column_header'])) $column_header = $db->getEscaped($field['_column_header']);
				else $column_header = '';
				$newvalues['field_column_header'] = $column_header;
				$newvalues['field_default_value'] = $db->getEscaped($field['_default_value']);
				$newvalues['field_order'] = $field['_order'];
				$newvalues['field_replace'] = $field['_replace'];
				$row->bind($newvalues);
				
				/* Store the new field */
				if (!$row->store()) {
					$notsaved++;
				}
				else {
					$saved++;
					$row->reset();
				}
			}
			
			if ($saved > 0) $mainframe->enqueueMessage(str_replace('{X}', $saved, JText::_('SAVED_X_TEMPLATE_FIELDS')));
			if ($notsaved > 0) $mainframe->enqueueMessage(str_replace('{X}', $notsaved, JText::_('NOT_SAVED_X_TEMPLATE_FIELDS')), 'error');
			/* We reached here, so no problems */
			return true;
		}
		else return false;
	}
	
	/**
	* Adds a new field to a template
	 */
	public function getAddField() {
		$db = JFactory::getDBO();
		$mainframe = Jfactory::getApplication();
		
		/* Get the template ID */
		$template_id = JRequest::getCmd('template_id');
		
		/* Get the field data */
		$fields = JRequest::getVar('field');
		$field = $fields['{fill}'];
		
		$q = "INSERT INTO #__csvivirtuemart_template_fields 
			(field_template_id, field_name, field_column_header, field_default_value, field_order, `field_replace`, published) 
			VALUES (".$template_id.", '"
					.$db->getEscaped($field['_field_name'])."','"
					.$db->getEscaped($field['_column_header'])."','"
					.$field['_default_value']."', '"
					.$field['_order']."', "
					.$field['_replace'].", 1)";
		$db->setQuery($q);
		if ($db->query()) {
			$mainframe->enqueueMessage(JText::_('Template field has been added'));
			return true;
		}
		else {
			$mainframe->enqueueMessage(JText::_('Template field has not been added').'<br />'.$db->getErrorMsg(), 'error');
			return false;
		}
	}
	
	/**
	* Renumber fields
	*
	* Renumbers all fields ordered by published state
	 */
	public function getRenumberFields() {
		$mainframe = Jfactory::getApplication();
		$db = JFactory::getDBO();
		
		/* Get the template ID */
		$template_id = JRequest::getCmd('template_id');
		
		$q = "SELECT id
			FROM #__csvivirtuemart_template_fields
			WHERE field_template_id = ".$template_id."
			ORDER BY published DESC, field_order, field_name";
		$db->setQuery($q);
		$db->query();
		$fieldorder = $db->loadObjectList();
		$process = true;
		$errormsg = '';
		foreach ($fieldorder as $order => $field) {
			$q = "UPDATE #__csvivirtuemart_template_fields
				SET field_order = ".($order+1)."
				WHERE id = ".$field->id;
			$db->setQuery($q);
			if (!$db->query()) {
				$process = false;
				$errormsg .= $db->getErrorMsg();
			}
		}
		if ($process) $mainframe->enqueueMessage(JText::_('New field order has been saved'));
		else $mainframe->enqueueMessage(JText::_('There was a problem saving the new field order').'<br />'.$errormsg, 'error');
	}
	
	/**
	* Deletes a selected field
	*
	* Renumbers all fields ordered by published state
	* @param $id integer The id of the template
	 */
	function getDeleteField() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$cid = JRequest::getVar('cid');
		if (is_null($cid)) return false;
		$cids = implode( ',', $cid );
		$q = "DELETE from #__csvivirtuemart_template_fields WHERE id IN (".$cids.")";
		$db->setQuery($q);
		if ($db->query()) return true;
		else {
			$csvilog->AddMessage('info', $db->getErrorMsg());
			return false;
		}
	}
	
	/**
	* Add the quick fields to the template
	 */
	public function getSaveFieldsQ() {
		$db = JFactory::getDBO();
		$cids = JRequest::getVar('cid');
		$field_order = JRequest::getVar('field_order');
		$template_id = JRequest::getInt('template_id');
		
		/* Remove the empty values from the field order */
		foreach ($field_order as $fkey => $value) {
			if (empty($value)) unset($field_order[$fkey]);
		}
		$field_order = array_merge(array(), $field_order);
		
		$q = "INSERT INTO #__csvivirtuemart_template_fields (id, field_template_id, field_order, field_name, published) VALUES ";
		foreach ($cids as $kcid => $field_name) {
			$q .= '(0,'.$template_id.','.$field_order[$kcid].','.$db->Quote($field_name).", 1),\n";
		}
		$q = substr(trim($q), 0, -1).';';
		$db->setQuery($q);
		return $db->query();
	}
}
?>