<?php
/**
* Maintenance model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: maintenance.php 1152 2010-02-07 09:42:42Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Maintenance Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelMaintenance extends JModel {
	
	/**
	* Empty VirtueMart tables
	*
	* @todo Write out product type tables that get deleted
	 */
	public function getEmptyDatabase() {
		
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		/* Empty all the necessary tables */
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_price`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product price table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product price table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product price table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_mf_xref`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product manufacturer link table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product manufacturer link table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product manufacturer link table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_attribute`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product attribute table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product attribute table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product attribute table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_category`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty category table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Category table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Category table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_category_xref`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty category link table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Category link table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Category link table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_attribute_sku`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty attribute for parent products table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Attribute for parent products table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Attribute for parent products table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_category_xref`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product category link table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product category link table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product category link table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_discount`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product discount table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product discount table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product discount table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_type`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product type table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product type table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product type table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_type_parameter`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product type parameter table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product type parameter table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product type parameter table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_product_type_xref`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product type link table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product type link table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product type link table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_relations`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product relations table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product relations table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product relations table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "DELETE FROM `#__vm_manufacturer` WHERE manufacturer_id > 1;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty manufacturer table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Manufacturer table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Manufacturer table has not been emptied'));
		
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		$q = "TRUNCATE TABLE `#__vm_product_files`;";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', 'Empty product files table', true);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Product files table has been emptied'));
		else $csvilog->AddStats('incorrect', JText::_('Product files table has not been emptied'));
		
		/* Check if there are any product type tables created, if so, remove them */
		$q = "SHOW TABLES LIKE '%vm_product_type_%'";
		$db->setQuery($q);
		$tables = $db->loadResultArray();
		$config = new JConfig;
		foreach ($tables as $key => $tablename) {
			if (stristr('0123456789', substr($tablename, -1))) {
				JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
				$q_drop = "DROP TABLE ".$db->nameQuote($tablename);
				$db->setQuery($q_drop);
				$csvilog->AddMessage('debug', 'DEBUG_DELETE_PRODUCT_TYPE_NAME_TABLE'.' '.$tablename, true);
				if ($db->query()) $csvilog->AddStats('deleted', 'PRODUCT_TYPE_NAME_TABLE_DELETED'.' '.$tablename);
				else $csvilog->AddStats('incorrect', 'PRODUCT_TYPE_NAME_TABLE_NOT_DELETED'.' '.$tablename);
			}
		}
		return true;
	}
	
	/**
	* Remove orphaned fields
	 */
	public function getRemoveOrphan() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
		
		$q = "SELECT template_id FROM #__csvivirtuemart_templates";
		$db->setQuery($q);
		$records = $db->loadObjectList();
		if (count($records) == 0) {
			$q = "TRUNCATE TABLE `#__csvivirtuemart_template_fields`";
			$db->setQuery($q);
			if ($db->query()) $csvilog->AddStats('deleted', JText::_('ALL_TEMPLATE_FIELDS_DELETED'));
			else $csvilog->AddStats('incorrect', JText::_('ALL_TEMPLATE_FIELDS_NOT_DELETED'));
		}
		else {
			$foundids = '';
			$last = end(array_keys($records));
			foreach ($records as $key => $record) {
				$foundids .= $record->template_id;
				if ($last != $key) $foundids .= ',';
			}
			$q = "SELECT id FROM #__csvivirtuemart_template_fields
				WHERE field_template_id NOT IN (".$foundids.")";
			$db->setQuery($q);
			$records = $db->loadObjectList();
			if (count($records) > 0) {
				foreach ($records as $key => $record) {
					JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
					$q = "DELETE FROM #__csvivirtuemart_template_fields WHERE id = ".$record->id;
					$db->setQuery($q);
					if ($db->query()) $csvilog->AddStats('deleted', 'Field ID '.$record->id.' has been removed');
					else $csvilog->AddStats('incorrect', 'Field ID '.$record->id.' has not been removed');
				}
			}
			else $csvilog->AddStats('information', 'No orphaned fields found');
		}
		return true;
	}
	
	/**
	* Optimize CSV Improved and VirtueMart tables
	*
	* @todo clean up messages
	 */
	public function getOptimizeTables() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$tables = array();
		$tables[] = '#__csvivirtuemart_available_fields';
		$tables[] = '#__csvivirtuemart_template_fields';
		$tables[] = '#__csvivirtuemart_template_types';
		$tables[] = '#__csvivirtuemart_templates';
		$tables[] = '#__csvivirtuemart_logs';
		$tables[] = '#__csvivirtuemart_log_details';
		$tables[] = '#__vm_product';
		$tables[] = '#__vm_product_price';
		$tables[] = '#__vm_product_mf_xref';
		$tables[] = '#__vm_product_attribute';
		$tables[] = '#__vm_category';
		$tables[] = '#__vm_category_xref';
		$tables[] = '#__vm_product_attribute_sku';
		$tables[] = '#__vm_product_category_xref';
		$tables[] = '#__vm_product_discount';
		$tables[] = '#__vm_product_type';
		$tables[] = '#__vm_product_type_parameter';
		$tables[] = '#__vm_product_product_type_xref';
		$tables[] = '#__vm_product_relations';
		$tables[] = '#__vm_manufacturer';
		
		foreach ($tables as $id => $tablename) {
			JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
			$q =  "OPTIMIZE TABLE ".$tablename;
			$db->setQuery($q);
			if ($db->query()) $csvilog->AddStats('information', JText::_('Table has been optimized').' '.substr($tablename, 3));
			else $csvilog->AddStats('incorrect', JText::_('Table has not been optimized').' '.substr($tablename,3));
		}
		return true;
	}
	
	/**
	* Sorts all VirtueMart categories in alphabetical order
	 */
	public function getSortCategories() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		/* Get all categories */
		$query  = "SELECT LOWER(category_name) AS category_name, category_child_id as cid, category_parent_id as pid
				FROM #__vm_category, #__vm_category_xref WHERE
				#__vm_category.category_id=#__vm_category_xref.category_child_id ";
		
		/* Execute the query */
		$db->setQuery($query);
		
		$records = $db->loadObjectList();
		if (count($records) > 0) {
			$categories = array();
			
			/* Group all categories together according to their level */
			foreach ($records as $key => $record) {
				$categories[$record->pid][$record->cid] = $record->category_name;
			}
			
			/* Sort the categories and store the item list */
			foreach ($categories as $id => $category) {
				asort($category);
				$listorder = 1;
				foreach ($category as $category_id => $category_name) {
					/* Store the new sort order */
					$q = "UPDATE #__vm_category
						SET list_order = '".$listorder."'
						WHERE category_id = '".$category_id."'";
					$db->setQuery($q);
					$db->query();
					JRequest::setVar('currentline', JRequest::getInt('currentline', 0)+1);
					$csvilog->AddStats('information', "Saved category ".$category_name." with order ".$listorder);
					$listorder++;
				}
			}
		}
		else $csvilog->AddStats('information', JText::_('NO_CATEGORIES_FOUND'));
		return true;
	}
	
	/**
	* Get the current size of the product name field
	 */
	public function getSizeProductName() {
	 	$db = JFactory::getDBO();
	 	$q = "SELECT MAX(LENGTH(product_name)) FROM #__vm_product";
	 	$db->setQuery($q);
	 	return $db->loadResult();
	}
	
	/**
	* Adjust the size of the product name field
	 */
	public function getResizeProductName() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "ALTER TABLE #__vm_product CHANGE `product_name` `product_name` VARCHAR(".JRequest::getInt('productnamefieldlength').") DEFAULT NULL NULL;";
		$db->setQuery($q);
		if ($db->query()) {
			$csvilog->AddStats('information', str_replace('{size}', JRequest::getInt('productnamefieldlength'), JText::_('CHANGE_NAME_LENGTH_OK')));
			return true;
		}
		else {
			$csvilog->AddStats('incorrect', JText::_('CHANGE_NAME_LENGTH_NOK').' '.$db->getErrorMsg());
			return false;
		}
	}
	
	/**
	* Add exchange rates
	* The eurofxref-daily.xml file is updated daily between 14:15 and 15:00 CET
	 */
	public function getExchangeRates() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		/* Read eurofxref-daily.xml file in memory */
		$XMLContent= file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
		
		/* Process the file */
		if ($XMLContent) {
			/* Empty table */
			$q = "TRUNCATE TABLE `#__csvivirtuemart_currency`;";
			$db->setQuery($q);
			$db->query();
			
			/* Add the Euro */
			$q = "INSERT INTO #__csvivirtuemart_currency (currency_code, currency_rate) 
				VALUES ('EUR', 1)";
			$db->setQuery($q);
			$db->query();
			
			$currencyCode = array();
			$rate = array();
			foreach ($XMLContent as $line) {
				if (ereg("currency='([[:alpha:]]+)'",$line,$currencyCode)) {
					if (ereg("rate='([[:graph:]]+)'",$line,$rate)) {
						$q = "INSERT INTO #__csvivirtuemart_currency (currency_code, currency_rate) 
							VALUES (".$db->Quote($currencyCode[1]).", ".$rate[1].")";
						$db->setQuery($q);
						if ($db->query()) {
							$rate_name = 'EXCHANGE_RATE_'.$currencyCode[1].'_ADDED'; 
							$csvilog->AddStats('added', JText::_($rate_name));
						}
						else $csvilog->AddStats('incorrect', JText::_($rate_name));
					}
				}
			}
		}
		else $csvilog->AddStats('incorrect', JText::_('CANNOT_LOAD_EXCHANGERATE_FILE'));
	}
	
	/**
	* Remove all categories that have no products
	* Parent categories are only deleted if there are no more children left
	 */
	public function getRemoveEmptyCategories() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		/* Get all categories */
		$query  = "SELECT category_child_id as cid, 
						category_parent_id as pid
				FROM #__vm_category
				LEFT JOIN #__vm_category_xref 
				ON #__vm_category.category_id = #__vm_category_xref.category_child_id
				LEFT JOIN #__vm_product_category_xref
				ON #__vm_category.category_id = #__vm_product_category_xref.category_id
				group by #__vm_product_category_xref.product_id ";
		
		/* Execute the query */
		$db->setQuery($query);
		
		$records = $db->loadObjectList();
		if (count($records) > 0) {
			$categories = array();
			
			/* Group all categories together according to their level */
			foreach ($records as $key => $record) {
				$categories[] = $record->pid;
				$categories[] = $record->cid;
			}
			$categories = array_unique($categories);
			
			/* Remove all categories except the ones we have */
			$q = "DELETE FROM #__vm_category 
				WHERE category_id NOT IN (".implode(', ', $categories).")";
			$db->setQuery($q);
			if ($db->query()) $csvilog->AddStats('deleted', JText::_('MAINTENANCE_CATEGORIES_DELETED'));
			else $csvilog->AddStats('incorrect', JText::_('MAINTENANCE_CATEGORIES_NOT_DELETED'));
			
			/* Remove all category parent-child relations except the ones we have */
			$q = "DELETE FROM #__vm_category_xref 
				WHERE category_child_id NOT IN (".implode(', ', $categories).")";
			$db->setQuery($q);
			if ($db->query()) $csvilog->AddStats('deleted', JText::_('MAINTENANCE_CATEGORIES_XREF_DELETED'));
			else $csvilog->AddStats('incorrect', JText::_('MAINTENANCE_CATEGORIES_XREF_NOT_DELETED'));
		}
		else $csvilog->AddStats('information', JText::_('NO_CATEGORIES_FOUND'));
	}
	
	/**
	* Install default templates
	 */
	public function getInstallDefaultTemplates() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		/* List of standard templates */
		$standardtemplates = array('CSVI Google Base export XML',
							'CSVI Product import',
							'CSVI Product files import',
							'CSVI Multiple Prices import',
							'CSVI Manufacturer details import',
							'CSVI Category details import', 
							'CSVI Category details export',
							'CSVI Multiple Prices export',
							'CSVI Product files export',
							'CSVI Product export');
		
		/* Get a list of templates */
		$db->setQuery("SELECT template_name FROM #__csvivirtuemart_templates");
		$db->query();
		$installedtemplates = $db->loadResultArray();
		
		/* Check if there are templates not yet */
		$installtemplates = array_diff($standardtemplates, $installedtemplates);
		
		/* Set the headers for template insert */
		$templateinsert = "INSERT IGNORE INTO `#__csvivirtuemart_templates` (
						`template_name`, 
						`template_type`, 
						`skip_first_line`, 
						`use_column_headers`, 
						`collect_debug_info`, 
						`overwrite_existing_data`, 
						`skip_default_value`, 
						`show_preview`, 
						`include_column_headers`, 
						`text_enclosure`, 
						`field_delimiter`, 
						`export_type`, 
						`export_site`, 
						`thumb_width`, 
						`thumb_height`, 
						`shopper_group_id`, 
						`producturl_suffix`, 
						`file_location_product_images`, 
						`product_publish`,
						`max_execution_time`,
						`max_input_time`,
						`memory_limit`,
						`post_max_size`,
						`upload_max_filesize`
						) VALUES ";
						
		/* Get system limit values */
		$max_execution_time = intval(ini_get('max_execution_time'));
		$max_input_time = intval(ini_get('max_input_time'));
		$memory_limit = intval(ini_get('memory_limit'));
		$post_max_size = intval(ini_get('post_max_size'));
		$upload_max_filesize = intval(ini_get('max_execution_time'));
		
		/* Standard templates data */
		$templatedata = array();
		$templatedata[] = "('CSVI Google Base Export XML', 'productexport', 0, 1, 1, 1, 0, 0, 1, '~', '^', 'xml', 'froogle', 0, 0, NULL, NULL, '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Product Import', 'productimport', 1, 0, 0, 1, 0, 1, 0, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Product Export', 'productexport', 0, 0, 0, 0, 0, 0, 1, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Product files import', 'productfilesimport', 1, 0, 0, 1, 0, 1, 0, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Multiple Prices import', 'multiplepricesimport', 1, 0, 0, 1, 0, 1, 0, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Multiple Prices export', 'multiplepricesexport', 0, 0, 0, 0, 0, 0, 1, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Manufacturer details import', 'manufacturerimport', 1, 0, 0, 1, 0, 1, 0, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Category details import', 'categorydetailsimport', 1, 0, 0, 1, 0, 1, 0, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Category details export', 'categorydetailsexport', 0, 0, 0, 0, 0, 0, 1, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		$templatedata[] = "('CSVI Product files export', 'productfilesexport', 1, 0, 0, 1, 0, 1, 1, '~', '^', 'csv', '', 0, 0, 0, '', '', '', ".$max_execution_time.",".$max_input_time.",".$memory_limit.",".$post_max_size.",".$upload_max_filesize.")";
		
		/* Set the headers for template field insert */
		$templatefieldinsert = "INSERT IGNORE INTO `#__csvivirtuemart_template_fields` (`field_template_id`, `field_name`, `field_column_header`, `field_default_value`, `field_order`, `published`) VALUES ";
		
		/* Standard templatefields data */
		$templatefielddata[1][] = "({lastid}, 'product_name', 'title', '', 1, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_url', 'link', 'http://www.yoursite.com/', 2, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_desc', 'description', '', 3, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_sku', 'g:id', '', 4, 1)";
		$templatefielddata[1][] = "({lastid}, 'picture_url', 'g:image_link', '', 5, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_price', 'g:price', '', 6, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:condition', 'new', 7, 1)";
		$templatefielddata[1][] = "({lastid}, 'manufacturer_name', 'g:brand', 'Not Available', 8, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:condition', 'New', 9, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_notes', '30 Days Money Back Guarantee', 10, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:expiration_date', 'None', 11, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_width', 'g:width', 'Not Available', 12, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'Check', 13, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'Visa', 14, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'MasterCard', 15, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'AmericanExpress', 16, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'Paypal', 17, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:payment_accepted', 'Money order', 18, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_weight', 'g:weight', 'Not Available', 19, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_length', 'g:lenght', 'Not Available', 20, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:price_type', 'Non Negotiable', 21, 1)";
		$templatefielddata[1][] = "({lastid}, 'product_in_stock', 'g:quantity', 'Not Available', 22, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:tax_region', 'Florida', 23, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:tax_percent', '6', 24, 1)";
		$templatefielddata[1][] = "({lastid}, 'attribute', 'g:tech_spec_link', 'http://www.yoursite.com/technical_specifications.html', 25, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:pickup', 'FALSE', 26, 1)";
		$templatefielddata[1][] = "({lastid}, 'custom', 'g:shipping', 'US:UPS Ground:5.00', 27, 1)";
		
		$templatefielddata[2][] = "({lastid}, 'category_path', '', '', 3, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_availability', '', '', 10, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_available_date', '', '', 11, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_currency', '', 'EUR', 12, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_desc', '', '', 6, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_discount', '', '', 13, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_discount_date_end', '', '', 14, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_discount_date_start', '', '', 15, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_full_image', '', '', 8, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_name', '', '', 4, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_packaging', '', '', 16, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_parent_sku', '', '', 2, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_price', '', '', 7, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_publish', '', 'Y', 17, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_s_desc', '', '', 5, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_special', '', '', 18, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_tax', '', '', 19, 1)";
		$templatefielddata[2][] = "({lastid}, 'product_thumb_image', '', '', 9, 1)";
		
		$templatefielddata[3][] = "({lastid}, 'category_path', '', '', 3, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_availability', '', '', 10, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_available_date', '', '', 11, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_currency', '', 'EUR', 12, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_desc', '', '', 6, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_discount', '', '', 13, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_discount_date_end', '', '', 14, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_discount_date_start', '', '', 15, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_full_image', '', '', 8, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_name', '', '', 4, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_packaging', '', '', 16, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_parent_sku', '', '', 2, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_price', '', '', 7, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_publish', '', 'Y', 17, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_s_desc', '', '', 5, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_special', '', '', 18, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_tax', '', '', 19, 1)";
		$templatefielddata[3][] = "({lastid}, 'product_thumb_image', '', '', 9, 1)";
		
		$templatefielddata[4][] = "({lastid}, 'product_files_file_description', '', '', 4, 1)";
		$templatefielddata[4][] = "({lastid}, 'product_files_file_name', '', '', 2, 1)";
		$templatefielddata[4][] = "({lastid}, 'product_files_file_published', '', '', 6, 1)";
		$templatefielddata[4][] = "({lastid}, 'product_files_file_title', '', '', 3, 1)";
		$templatefielddata[4][] = "({lastid}, 'product_files_file_url', '', '', 5, 1)";
		$templatefielddata[4][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		
		$templatefielddata[5][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		$templatefielddata[5][] = "({lastid}, 'product_currency', '', '', 3, 1)";
		$templatefielddata[5][] = "({lastid}, 'price_quantity_start', '', '', 4, 1)";
		$templatefielddata[5][] = "({lastid}, 'price_quantity_end', '', '', 5, 1)";
		$templatefielddata[5][] = "({lastid}, 'product_price', '', '', 2, 1)";
		
		$templatefielddata[6][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		$templatefielddata[6][] = "({lastid}, 'product_currency', '', '', 3, 1)";
		$templatefielddata[6][] = "({lastid}, 'price_quantity_start', '', '', 4, 1)";
		$templatefielddata[6][] = "({lastid}, 'price_quantity_end', '', '', 5, 1)";
		$templatefielddata[6][] = "({lastid}, 'product_price', '', '', 2, 1)";
		
		$templatefielddata[7][] = "({lastid}, 'manufacturer_desc', '', '', 2, 1)";
		$templatefielddata[7][] = "({lastid}, 'manufacturer_email', '', '', 3, 1)";
		$templatefielddata[7][] = "({lastid}, 'manufacturer_name', '', '', 1, 1)";
		$templatefielddata[7][] = "({lastid}, 'manufacturer_category_name', '', '', 5, 1)";
		$templatefielddata[7][] = "({lastid}, 'manufacturer_url', '', '', 4, 1)";
		
		$templatefielddata[8][] = "({lastid}, 'category_path', '', '', 1, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_description', '', '', 2, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_thumb_image', '', '', 4, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_full_image', '', '', 3, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_publish', '', '', 8, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_browsepage', '', '', 6, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_products_per_row', '', '', 5, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_flypage', '', '', 7, 1)";
		$templatefielddata[8][] = "({lastid}, 'category_list_order', '', '', 9, 1)";
		
		$templatefielddata[9][] = "({lastid}, 'category_path', '', '', 1, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_description', '', '', 2, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_thumb_image', '', '', 4, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_full_image', '', '', 3, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_publish', '', '', 8, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_browsepage', '', '', 6, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_products_per_row', '', '', 5, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_flypage', '', '', 7, 1)";
		$templatefielddata[9][] = "({lastid}, 'category_list_order', '', '', 9, 1)";
		
		$templatefielddata[10][] = "({lastid}, 'product_files_file_description', '', '', 4, 1)";
		$templatefielddata[10][] = "({lastid}, 'product_files_file_name', '', '', 2, 1)";
		$templatefielddata[10][] = "({lastid}, 'product_files_file_published', '', '', 6, 1)";
		$templatefielddata[10][] = "({lastid}, 'product_files_file_title', '', '', 3, 1)";
		$templatefielddata[10][] = "({lastid}, 'product_files_file_url', '', '', 5, 1)";
		$templatefielddata[10][] = "({lastid}, 'product_sku', '', '', 1, 1)";
		
		
		foreach ($installtemplates as $key => $templatename) {
			/* Add the template */
			$db->setQuery($templateinsert.$templatedata[$key]);
			$db->query();
			
			$insertid = $db->insertid();
			/* Add the template data */
			foreach ($templatefielddata[$key+1] as $id => $fielddata) {
				$db->setQuery($templatefieldinsert.str_replace('{lastid}', $insertid, $fielddata));
				$db->query();
			}
		}
		$csvilog->AddStats('added', JText::_('SAMPLE_TEMPLATE_INSTALLED'));
	}
	
	/**
	* Clean the CSVI VirtueMart cache
	*/
	public function getCleanCache() {
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$folder = JPATH_ROOT.DS.'administrator'.DS.'cache'.DS.'com_csvivirtuemart';
		
		/* Delete all import files left behind in the folder */
		JFile::delete(JFolder::files($folder, '.', false, true));
		
		/* Delete all import folders left behind in the folder */
		$folders = array();
		$folders = JFolder::folders($folder, '.', true, true, array('debug'));
		
		if (!empty($folders)) {
			foreach ($folders as $path) {
				JFolder::delete($path);
			}
		}
		
		/* Load the files */
		$files = JFolder::files($folder.DS.'debug', '.', false, true);
		if ($files) {
			/* Remove any debug logs that are still there but not in the database */
			$q = "SELECT CONCAT(".$db->Quote($folder.DS.'debug'.DS.'com_csvivirtuemart.log.').", import_id, '.php') AS filename
				FROM #__csvivirtuemart_logs
				WHERE import_id > 0
				GROUP BY import_id";
			$db->setQuery($q);
			$ids = $db->loadResultArray();
			
			/* Delete all obsolete files */
			JFile::delete(array_diff($files, $ids));
		}
		
		$csvilog->AddStats('deleted', JText::_('CACHE_CLEANED'));
	}
}
?>