<?php
/**
* Template export class
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: templateexport.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
 
/**
* Processor for template exports
*
* @package CSVIVirtueMart
* @subpackage Export
 */
class CsvivirtuemartModelTemplateExport extends JModel {
	
	/* Private variables */
	private $_exportmodel = null;
	
	
	/** 
	* Template export
	*
	* Exports template data
	*
	* */
	public function getStart() {
		
		/* Get some basic data */
		$db = JFactory::getDBO();
		$csvidb = new CsviDb();
		$csvilog = JRequest::getVar('csvilog');
		$template = JRequest::getVar('template');
		$exportclass = JRequest::getVar('exportclass');
		$export_fields = JRequest::getVar('exportfields');
		
		/* Get the general export functions */
		$this->_exportmodel = new CsvivirtuemartModelexportfile();
		
		/* Get the template settings from the database */
		$q = 'SELECT t.*, s.shopper_group_name 
			FROM #__csvivirtuemart_templates t
			LEFT JOIN #__vm_shopper_group s
			ON t.shopper_group_id = s.shopper_group_id';
		$templatelist = JRequest::getVar('exporttemplate');
		if (count($templatelist) > 0 && !empty($templatelist[0])) {
			$last = end(array_keys($templatelist));
			$q .= ' WHERE template_id IN (';
			foreach ($templatelist as $key => $value) {
			    $q .= $value;
			    if ($last != $key) $q .= ",";
			}
			$q .= ')';
		 }
		 
		/* Check if we need to group the orders together */
		$groupby = JRequest::getVar('groupby', false);
		if ($groupby) {
			$q .= " GROUP BY ";
			foreach ($export_fields as $column_id => $field) {
				$q .= $field->field_name.", ";
			}
			$q = substr($q, 0, -2);
		}
		
		/* Order templates by name */
		$q .= ' ORDER BY t.template_name ';
		 
		/* Add a limit if user wants us to */
		$q .= $this->_exportmodel->ExportLimit();
		 
		$csvidb->setQuery($q);
		$logcount = $db->getAffectedRows();
		JRequest::setVar('logcount', array('export' => $logcount));
		if ($db->getErrorNum() > 0) $csvilog->AddStats('incorrect', $db->getErrorMsg(), true);
		if ($logcount > 0) {
			while ($record = $csvidb->getRow()) {
				$contents = '';
				if ($template->export_type == 'xml') $contents .= $exportclass->NodeStart();
				foreach ($export_fields as $column_id => $field) {
					$fieldname = $field->field_name;
					/* Add the replacement */
					if (isset($record->$fieldname)) {
						if ($field->replace) $fieldvalue = $this->_exportmodel->replaceValue($field->field_id, $record->$fieldname);
						else $fieldvalue = $record->$fieldname;
					}
					else $fieldvalue = '';
					/* Check if we have any content otherwise use the default value */
					if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
					$contents .= $this->_exportmodel->AddExportField($fieldvalue, $fieldname, $field->column_header);
				}
				if ($template->export_type == 'xml') {
				  $contents .= $exportclass->NodeEnd();
				}
				else if (substr($contents, -1) == $template->field_delimiter) {
				  $contents = substr($contents, 0 , -1);
				}
				$contents .= "\r\n";
				
				/* Output the contents */
				CsvivirtuemartModelExportfile::writeOutput($contents);
				
				/* Clean up */
				unset($contents);
			}
		}
	}
}
?>