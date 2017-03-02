<?php
/**
* Product type names export class
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: producttypenamesexport.php 1117 2010-01-01 21:39:52Z Roland $
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
 
/**
* Processor for product type names exports
*
* @package CSVIVirtueMart
* @subpackage Export
*/

class CsvivirtuemartModelProductTypenamesExport extends JModel {
	
	/* Private variables */
	private $_exportmodel = null;
	
	
	/** 
	* Product export
	*
	* Exports product data to either csv or xml format
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
		
		/* Build something fancy to only get the fieldnames the user wants */
		$userfields = array();
		$vmtables = array();
		$vmids = array();
		foreach ($export_fields as $column_id => $field) {
			switch ($field->field_name) {
				case 'product_sku':
					$userfields[] = '#__vm_product.product_sku';
					break;
				case 'product_id':
					$userfields[] = '#__vm_product.product_id';
					break;
				case 'product_type_name':
					$userfields[] = '#__vm_product_type.product_type_name';
					break;
				case 'product_type_id':
					$userfields[] = '#__vm_product_type.product_type_id';
					break;
				/* Man made fields, do not export them */
				case 'custom':
					break;
				default:
					/* Check which product type table belongs to the field */
					$q = "SELECT vm_table FROM #__csvivirtuemart_available_fields WHERE csvi_name = ".$db->Quote($field->field_name)." LIMIT 1";
					$db->setQuery($q);
					$vmtables[$db->loadResult()][] = $field->field_name;
					$vmids[] = $db->loadResult();
					// $userfields[] = $db->nameQuote('#__'.$vmtable->vm_table).'.'.$db->nameQuote($field->field_name);
					break;
			}
		}
		
		/** Export SQL Query
		* Get all products - including items
		* as well as products without a price
		* 
		*/
		$queries = array();
		$filterid = '';
		$userfields = array_unique($userfields);
		foreach ($vmids AS $vmidkey => $vmid) {
			$q = "(SELECT ".implode(",\n", $userfields);
			foreach ($vmtables as $vmtableskey => $vmfields) {
				if ($vmid == $vmtableskey) {
					$filterid = str_replace('vm_product_type_', '', $vmid);
					foreach ($vmfields AS $vmfieldkey => $vmfield) {
						$q .= ",\n".$db->nameQuote('#__'.$vmid).'.'.$db->nameQuote($vmfield).' AS '.$vmfield;
					}
				}
				else {
					foreach ($vmfields AS $vmfieldkey => $vmfield) {
						$q .= ",\n '' AS ".$vmfield;
					}
				}
			}
			$q .= ' FROM #__vm_product_type
				LEFT JOIN #__vm_product_product_type_xref
				ON #__vm_product_product_type_xref.product_type_id = #__vm_product_type.product_type_id
				LEFT JOIN #__vm_product
				ON #__vm_product_product_type_xref.product_id = #__vm_product.product_id ';
			
			/* Add the product type X tables */
			$q .= "\nLEFT JOIN #__".$vmid." ON #__".$vmid.".product_id = #__vm_product.product_id "."\n";
				
			/* Check if there are any selectors */
			$selectors = array();
			
			/* Add product type ID checks */
			$selectors[] = '#__vm_product_type.product_type_id = '.$filterid;
			
			/* Filter by product type name */
			$producttypenames = JRequest::getVar('producttypenames', false);
			if ($producttypenames && $producttypenames[0] != '') {
				$selectors[] = '#__vm_product_type.product_type_id IN (\''.implode("','", $producttypenames).'\')';
			}
			
			/* Check if we need to attach any selectors to the query */
			if (count($selectors) > 0 ) $q .= ' WHERE '.implode(' AND ', $selectors)."\n";
			
			/* Check if we need to group the orders together */
			$groupby = JRequest::getVar('groupby', false);
			if ($groupby) {
				$q .= " GROUP BY ";
				foreach ($export_fields as $column_id => $field) {
					switch ($field->field_name) {
						case 'custom':
							break;
						case 'product_sku':
							$q .= '#__vm_product.product_sku, ';
							break;
						case 'product_id':
							$q .= '#__vm_product.product_id, ';
							break;
						case 'product_type_name':
							$q .= '#__vm_product_type.product_type_name, ';
							break;
						case 'product_type_id':
							$q .= '#__vm_product_type.product_type_id, ';
							break;
						default:
							$q .= '`'.$field->field_name.'`, ';
							break;
					}
				}
				$q = substr($q, 0, -2);
			}
			
			/* Order products by SKU */
			$q .= ' ORDER BY #__vm_product_type.product_type_id ';
			
			/* Add export limits */
			$q .= $this->_exportmodel->ExportLimit();
			$queries[] = $q.')';
		}
		
		/* Create the full query */
		$q = implode("\nUNION\n", $queries);
		
		/* Execute the query */
		$csvidb->setQuery($q);
		
		$logcount = $db->getAffectedRows();
		JRequest::setVar('logcount', array('export' => $logcount));
		if ($logcount > 0) {
			while ($record = $csvidb->getRow()) {
				$contents = '';
				if ($template->export_type == 'xml' || $template->export_type == 'html') $contents .= $exportclass->NodeStart();
				foreach ($export_fields as $column_id => $field) {
					$fieldname = $field->field_name;
					/* Add the replacement */
					if (isset($record->$fieldname)) {
						if ($field->replace) $fieldvalue = $this->_exportmodel->replaceValue($record->$fieldname);
						else $fieldvalue = $record->$fieldname;
					}
					else $fieldvalue = '';
					switch ($fieldname) {
						default:
							/* Check if we have any content otherwise use the default value */
							if (strlen(trim($fieldvalue)) == 0) $fieldvalue = $field->default_value;
							$contents .= $this->_exportmodel->AddExportField($fieldvalue, $fieldname, $field->column_header);
							break;
					}
				}
				if ($template->export_type == 'xml' || $template->export_type == 'html') {
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
		/* There are no records, write SQL query to log */
		else if ($db->getErrorNum() > 0) {
			$contents = JText::_('ERROR_RETRIEVING_DATA');
			CsvivirtuemartModelExportfile::writeOutput($contents);
			$csvilog->AddStats('incorrect', $db->getErrorMsg());
		}
		else {
			$contents = JText::_('NO_DATA_FOUND');
			/* Output the contents */
			CsvivirtuemartModelExportfile::writeOutput($contents);
		}
	}
}
?>