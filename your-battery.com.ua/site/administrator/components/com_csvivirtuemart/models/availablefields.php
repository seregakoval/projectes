<?php
/**
* Available fields model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: availablefields.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Available fields Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelAvailablefields extends JModel {
	
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
		$limit 				= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart 		= JRequest::getVar('limitstart', 0, '', 'int');
		
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
		
		/* Load filters */
		$filter = JRequest::getWord('searchtemplatetype', false);
		$filter_avfields = JRequest::getString('filter_avfields', false);
		$filter_order		= $mainframe->getUserStateFromRequest('availablefields.filter_order',		'filter_order',		'csvi_name',	'cmd');
		if ($filter_order == '') $filter_order = 'csvi_name';
		$filter_order_Dir	= $mainframe->getUserStateFromRequest('availablefields.filter_order_Dir',	'filter_order_Dir',	'asc',	'word');
		if ($filter_order_Dir == '') $filter_order_Dir = 'asc';
		$filter_state		= $mainframe->getUserStateFromRequest('availablefields.filter_state',		'filter_state',		'',	'word');
		$filters = array();
		
		/* Start query */
		$q = "SELECT * FROM ".$db->nameQuote('#__csvivirtuemart_available_fields')." AS c ";
		
		/* Add filters */
		if ($filter) {
			$table = $this->GetAvailableFields($filter);
			$filters[] = '('.$db->nameQuote('vm_table')." = '" . implode( "' OR vm_table ='", $table )."')";
		}
		
		if ($filter_avfields) $filters[] = "(csvi_name LIKE ".$db->Quote('%'.$filter_avfields.'%')." OR vm_name LIKE ".$db->Quote('%'.$filter_avfields.'%')." OR vm_table LIKE ".$db->Quote('%'.$filter_avfields.'%').")";
		
		if (count($filters) > 0) $q .= " WHERE ".implode(' AND ', $filters);
		if ($filter_order) $q .= " ORDER BY ".$filter_order.' '.$filter_order_Dir;
		
		return $q;
	}
	
	/**
	* Fill the available fields table
	 */
	public function getFillAvailableFields() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$queries = array();
		/* Empty the available fields first */
		$q = "TRUNCATE TABLE `#__csvivirtuemart_available_fields`";
		$db->setQuery($q);
		if ($db->query()) $csvilog->AddStats('empty', JText::_('Available fields table emptied'));
		else $csvilog->AddStats('error', JText::_('Available fields table could not be emptied'));
		$tablenames = array('csvivirtuemart_templates',
							'csvivirtuemart_template_fields',
							'vm_category',
							'vm_category_xref',
							'vm_country',
							'vm_coupons',
							'vm_currency',
							'vm_manufacturer',
							'vm_manufacturer_category',
							'vm_order_item',
							'vm_order_payment',
							'vm_order_status',
							'vm_order_user_info',
							'vm_orders',
							'vm_payment_method',
							'vm_product',
							'vm_product_attribute',
							'vm_product_attribute_sku',
							'vm_product_category_xref',
							'vm_product_discount',
							'vm_product_files',
							'vm_product_mf_xref',
							'vm_product_price',
							'vm_product_product_type_xref',
							'vm_product_relations',
							'vm_product_reviews',
							'vm_product_type',
							'vm_product_type_parameter',
							'vm_product_type_x',
							'vm_shipping_rate',
							'vm_shopper_group',
							'vm_shopper_vendor_xref',
							'vm_tax_rate',
							'vm_userfield',
							'vm_user_info',
							'vm_vendor',
							'vm_vendor_category',
							'users');
		foreach ($tablenames as $key => $tablename) {
			$fields = $this->DbFields($tablename, true);
			if (is_array($fields)) {
				foreach ($fields as $name => $value) {
					$csviname = $name;
					/* Rename certain fields */
					switch ($tablename) {
						case 'vm_country':
							switch ($name) {
								case 'country_name':
									$csviname = $name;
									break;
								default:
									$csviname = false;
									break;
							}
							break;
						case 'vm_product':
							switch($name) {
								case 'cdate':
									$csviname = 'product_cdate';
									break;
								case 'mdate':
									$csviname = 'product_mdate';
									break;
							}
							break;
						case 'vm_product_discount':
							switch($name) {
								case 'amount':
									$csviname = 'product_discount';
									break;
								case 'start_date':
									$csviname = 'product_discount_date_start';
									break;
								case 'end_date':
									$csviname = 'product_discount_date_end';
									break;
							}
							break;
						case 'vm_tax_rate':
							switch($name) {
								case 'tax_rate':
									$csviname = 'product_tax';
									break;
							}
							break;
						case 'vm_product_type_paramter':
							switch($name) {
								case 'parameter_name':
									$csviname = 'product_type_parameter_name';
									break;
								case 'parameter_label':
									$csviname = 'product_type_parameter_label';
									break;
								case 'parameter_description':
									$csviname = 'product_type_parameter_description';
									break;
								case 'parameter_list_order':
									$csviname = 'product_type_parameter_list_order';
									break;
								case 'parameter_parameter_type':
									$csviname = 'product_type_parameter_type';
									break;
								case 'parameter_values':
									$csviname = 'product_type_parameter_values';
									break;
								case 'parameter_multiselect':
									$csviname = 'product_type_parameter_multiselect';
									break;
								case 'parameter_default':
									$csviname = 'product_type_parameter_default';
									break;
								case 'parameter_unit':
									$csviname = 'product_type_parameter_unit';
									break;
							}
							break;
						case 'vm_product_files':
							switch($name) {
								case 'file_name':
									$csviname = 'product_files_file_name';
									break;
								case 'file_title':
									$csviname = 'product_files_file_title';
									break;
								case 'file_description':
									$csviname = 'product_files_file_description';
									break;
								case 'file_url':
									$csviname = 'product_files_file_url';
									break;
								case 'file_published':
									$csviname = 'product_files_file_published';
									break;
							}
							break;
						case 'vm_manufacturer':
							switch($name) {
								case 'mf_name':
									$csviname = 'manufacturer_name';
									break;
								case 'mf_email':
									$csviname = 'manufacturer_email';
									break;
								case 'mf_desc':
									$csviname = 'manufacturer_desc';
									break;
								case 'mf_url':
									$csviname = 'manufacturer_url';
									break;
								case 'mf_category_id':
									$csviname = 'manufacturer_category_id';
									break;
							}
							break;
						case 'vm_manufacturer_category':
							switch($name) {
								case 'mf_category_id':
									$csviname = 'manufacturer_category_id';
									break;
								case 'mf_category_name':
									$csviname = 'manufacturer_category_name';
									break;
								case 'mf_category_desc':
									$csviname = 'manufacturer_category_desc';
									break;
							}
							break;
						case 'vm_category':
							switch($name) {
								case 'products_per_row':
									$csviname = 'category_products_per_row';
									break;
								case 'list_order':
									$csviname = 'category_list_order';
									break;
							}
							break;
						case 'vm_orders':
							switch($name) {
								case 'cdate':
									$csviname = 'order_date';
									break;
								case 'mdate':
									$csviname = 'order_modified_date';
									break;
							}
							break;
						case 'vm_order_item':
							switch($name) {
								case 'product_item_price':
									$csviname = 'product_price';
									break;
								case 'order_item_sku':
									$csviname = 'product_sku';
									break;
								case 'order_item_name':
									$csviname = 'product_name';
									break;
							}
							break;
						case 'users':
							switch(strtolower($name)) {
								case 'email':
									$csviname = 'user_email';
									break;
								case 'sendemail':
									$csviname = 'sendemail';
									break;
								case 'registerdate':
									$csviname = 'registerdate';
									break;
							}
							break;
					}
					if ($csviname) {
						$queries[] = "("
									."0,"
									.$db->Quote($csviname).","
									.$db->Quote($name).","
									.$db->Quote($value)
									.")\n";
					}
				}
			}
		}
		$q = "INSERT INTO ".$db->nameQuote('#__csvivirtuemart_available_fields')." ("
								.$db->nameQuote('id').","
								.$db->nameQuote('csvi_name').","
								.$db->nameQuote('vm_name').","
								.$db->nameQuote('vm_table').")
								VALUES ";
		$q .= implode(",", $queries);
		$db->setQuery($q);
		
		if ($db->query()) $csvilog->AddStats('added', JText::_('AVAILABLE_FIELDS_HAVE_BEEN_ADDED'));
		else $csvilog->AddStats('error', JText::_('AVAILABLE_FIELDS_HAVE_NOT_BEEN_ADDED'));
		
		/* Add some custom fields */
		jimport('joomla.filesystem.file');
		if (JFile::exists(JPATH_COMPONENT.DS.'helpers'.DS.'availablefields_extra.sql')) {
			$q = JFile::read(JPATH_COMPONENT.DS.'helpers'.DS.'availablefields_extra.sql');
			$db->setQuery($q);
			if ($db->query()) $csvilog->AddStats('added', JText::_('CUSTOM_AVAILABLE_FIELDS_HAVE_BEEN_ADDED'));
			else $csvilog->AddStats('error', JText::_('CUSTOM_AVAILABLE_FIELDS_HAVE_NOT_BEEN_ADDED'));
		}
		else $csvilog->AddStats('error', JText::_('AVAILABLEFIELDS_EXTRA_NOT_FOUND'));
		return;
	}
	
	/**
	* Creates an array of custom database fields the user can use for import/export
	 */
	public function DbFields($table, $addname=false) {
		$db = JFactory::getDBO();
		$showtables = array();
		/* Collect the table names for the product types */
		if ($table == 'vm_product_type_x') {
			$q = "SHOW TABLES LIKE '%vm_product_type_%'";
			$db->setQuery($q);
			$tables = $db->loadResultArray();
			foreach ($tables as $key => $tablename) {
				if (stristr('0123456789', substr($tablename, -1))) {
					$showtables[] = str_replace($db->getPrefix(), '', $tablename);
				}
			}
		}
		else $showtables[] = $table;
		
		$customfields = array();
		foreach ($showtables as $key => $table) {
			$q = "SHOW COLUMNS FROM ".$db->nameQuote('#__'.$table);
			$db->setQuery($q);
			$fields = $db->loadObjectList();
			if (count($fields) > 0) {
				foreach ($fields as $key => $field) {
					if ($addname) $customfields[$field->Field] = $table;
					else $customfields[$field->Field] = null;
				}
			}
		}
		return $customfields;
	}
	
	/**
	* Retrieve a list of available fields from a certain table
	*
	* @todo Convert to object
	 */
	private function getAvailableDbFields($table) {
		$db = JFactory::getDBO();
		$tables = $db->nameQuote('vm_table')." = '" . implode( "' OR vm_table ='", $table )."'";
		$q = "SELECT csvi_name FROM ".$db->nameQuote('#__csvivirtuemart_available_fields')." WHERE ".$tables." GROUP BY csvi_name";
		
		$db->setQuery($q);
		return $db->loadResultArray();
	}
	
	/**
	* Get the fields belonging to a certain operation type
	*
	* @param string $type contains the name of the supported fields to activate
	 */
	function GetAvailableFields($type) {
		switch (strtolower($type)) {
			/* Imports */
			case 'productimport':
			case 'productexport':
				$tables = array('vm_product', 'vm_product_price', 'vm_product_category_xref',
								'vm_product_discount', 'vm_product_attribute',
								'vm_product_attribute_sku', 'vm_product_relations',
								'vm_manufacturer', 'vm_product_mf_xref',
								'vm_tax_rate', 'vm_shopper_group');
				break;
			case 'multiplepricesimport':
			case 'multiplepricesexport':
				$tables = array('vm_product_price');
				break;
			case 'couponsimport':
			case 'couponsexport':
				$tables = array('vm_coupons');
				break;
			case 'productfilesimport':
			case 'productfilesexport':
				$tables = array('vm_product_files');
				break;
			case 'producttypeimport':
			case 'producttypeexport':
				$tables = array('vm_product_type');
				break;
			case 'producttypeparametersimport':
			case 'producttypeparametersexport':
				$tables = array('vm_product_type_parameter');
				break;
			case 'producttypenamesimport':
			case 'producttypenamesexport':
				/**
				* An array of all fields that are available for a product type name import
				*
				* The list only contains 2 fields but more fieldnames need to be added
				* to import data. These fieldnames are the product type parameter names.
				* This allows for filling the parameters with data.
				*/
				$db = JFactory::getDBO();
				$q = "SELECT CONCAT('vm_product_type_', product_type_id) AS producttypes FROM #__vm_product_type";
				$db->setQuery($q);
				$tables = $db->loadResultArray();
				array_push($tables, 'vm_product_product_type_xref');
				break;
			case 'templateimport':
			case 'templateexport':
				$tables = array('csvivirtuemart_templates');
				break;
			case 'templatefieldsimport':
			case 'templatefieldsexport':
				$tables = array('csvivirtuemart_template_fields');
				break;
			case 'manufacturerimport':
			case 'manufacturerexport':
				$tables = array('vm_manufacturer');
				break;
			case 'manufacturercategoryimport':
				$tables = array('vm_manufacturer_category');
				break;
			case 'categorydetailsimport':
			case 'categorydetailsexport':
				$tables = array('vm_category');
				break;
			case 'userinfoimport':
			case 'userinfoexport':
				$tables = array('vm_user_info', 'vm_shopper_group', 'vm_shopper_vendor_xref', 'users');
				break;
			case 'orderexport':
				$tables = array('vm_orders', 'vm_order_item', 'vm_order_user_info',
								'vm_order_payment', 'vm_order_status', 'vm_payment_method',
								'vm_product_mf_xref', 'vm_manufacturer', 'users', 'vm_country');
				break;
			case 'shippingratesimport':
			case 'shippingratesexport':
				$tables = array('vm_shipping_rate', 'vm_currency');
				break;
			case 'productreviewsimport':
			case 'productreviewsexport':
				$tables = array('vm_product_reviews');
			case 'userfieldsimport':
			case 'userfieldsexport':
				$tables = array('vm_userfield');
				break;
			
		}
		/* Add the template type fields */
		$tables[] = strtolower($type);
		/* Check if we are viewing available fields */
		if (JRequest::getWord('searchtemplatetype', false)) return $tables;
		else return $this->getAvailableDbFields($tables);
	}
}
?>