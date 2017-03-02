<?php
/**
* Templates table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart_templates.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
* @todo Check out the reset function
 */
class TableCsvivirtuemart_templates extends JTable {
	/** @var int Primary key */
	var $template_id = 0;
	/** @var string */
	var $template_name = null;
	/** @var string */
	var $template_type = null;
	/** @var int */
	var $skip_first_line = 0;
	/** @var int */
	var $show_preview = 0;
	/** @var int */
	var $use_column_headers = 0;
	/** @var int */
	var $collect_debug_info = 0;
	/** @var int */
	var $overwrite_existing_data = 0;
	/** @var int */
	var $skip_default_value = 0;
	/** @var int */
	var $include_column_headers = 0;
	/** @var string */
	var $text_enclosure = null;
	/** @var string */
	var $field_delimiter = null;
	/** @var string */
	var $export_type = null;
	/** @var string */
	var $export_site = null;
	/** @var string */
	var $thumb_create = 0;
	/** @var int */
	var $thumb_width = null;
	/** @var int */
	var $thumb_height = null;
	/** @var int */
	var $shopper_group_id = null;
	/** @var string */
	var $producturl_suffix = null;
	/** @var string */
	var $file_location_product_images = null;
	/** @var string */
	var $file_location_category_images = null;
	/** @var string */
	var $file_location_media = null;
	/** @var string */
	var $file_location_export_files = null;
	/** @var string */
	var $product_publish = null;
	/** @var int */
	var $max_execution_time = null;
	/** @var int */
	var $max_input_time = null;
	/** @var int */
	var $memory_limit = null;
	/** @var int */
	var $post_max_size = null;
	/** @var int */
	var $upload_max_filesize = null;
	/** @var string */
	var $export_filename = null;
	/** @var string */
	var $manufacturer = null;
	/** @var boolean */
	var $ignore_non_exist = 0;
	/** @var string Sets the extension of the new thumbnail to be created */
	var $thumb_extension = 'none';
	/** @var boolean */
	var $append_categories = 0;
	/** @var string */
	var $export_date_format = 'd/m/Y H:i:s';
	/** @var boolean */
	var $use_system_limits = 0;
	/** @var boolean */
	var $add_currency_to_price = 0;
	/** @var boolean Sets whether or not the exported file should be e-mailed */
	var $export_email = 0;
	/** @var string  E-mail address to send the exported file to */
	var $export_email_addresses = null;
	/** @var string  Copy e-mail address to send the exported file to */
	var $export_email_addresses_cc = null;
	/** @var string  Blind e-mail address to send the exported file to */
	var $export_email_addresses_bcc = null;
	/** @var string Sets the subject of the e-mail to send */
	var $export_email_subject = null;
	/** @var string Sets the body text of the e-mail to send */
	var $export_email_body = null;
	/** @var bool Sets whether or not the image name should be created from the SKU */
	var $auto_generate_image_name = 0;
	/** @var string Sets the extension of the image names that are automatically created */
	var $auto_generate_image_name_ext = 'none';
	/** @var bool Sets whether or not the external images should be saved in the product folder */
	var $save_images_on_server = 0;
	/** @var bool Sets whether or not to unpublish all records before importing */
	var $unpublish_before_import = 0;
	/** @var int Contains the VirtueMart Item ID to use for export */
	var $vm_itemid = null;
	/** @var bool Sets whether or not to auto detect delimiters used */
	var $auto_detect_delimiters = 1;
	/** @var bool Sets whether or not the template can be exported on front-end */
	var $export_frontend = 0;
	/** @var string set the format of how the price should be exported */
	var $export_price_format = '%01.2f';
	
	/**
	* @param database A database connector object
	 */
	function __construct($db) {
		parent::__construct('#__csvivirtuemart_templates', 'template_id', $db );
	}
	
	/**
	* Give some standard values
	 */
	function setStandardValues() {
		/* Set some standard values */
		$this->skip_first_line = 0;
		$this->show_preview = 0;
		$this->use_column_headers = 1;
		$this->collect_debug_info = 0;
		$this->overwrite_existing_data = 1;
		$this->skip_default_value  = 0;
		$this->include_column_headers = 1;
		$this->ignore_non_exist = 0;
		$this->text_enclosure = '~';
		$this->field_delimiter = '^';
		$this->export_type = 'csv';
		$this->thumb_create = 0;
		$this->thumb_width = 90;
		$this->thumb_height = 90;
		$this->product_publish = 'Y';
		$this->file_location_product_images = JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'shop_image'.DS.'product';
		$this->file_location_category_images = JPATH_SITE.DS.'components'.DS.'com_virtuemart'.DS.'shop_image'.DS.'category';
		$this->file_location_media = JPATH_SITE.DS.'media';
		$this->file_location_export_files = JPATH_SITE;
		$this->max_execution_time = intval(ini_get('max_execution_time'));
		$this->max_input_time = intval(ini_get('max_input_time'));
		$this->memory_limit = intval(ini_get('memory_limit'));
		$this->post_max_size = intval(ini_get('post_max_size'));
		$this->upload_max_filesize = intval(ini_get('upload_max_filesize'));
		$this->append_categories = 0;
		$this->export_date_format = 'd/m/Y H:i:s';
		$this->use_system_limits = 0;
		$this->add_currency_to_price = 0;
		$this->export_email = 0;
		$this->export_email_addresses = null;
		$this->export_email_addresses_cc = null;
		$this->export_email_addresses_bcc = null;
		$this->export_email_subject = null;
		$this->export_email_body = null;
		$this->auto_generate_image_name = 0;
		$this->save_images_on_server = 0;
		$this->auto_generate_image_name_ext = 'none';
		$this->unpublish_before_import = 0;
		$this->vm_itemid = 0;
		$this->auto_detect_delimiters = 1;
		$this->export_frontend = 0;
	}
	
	/**
	* Cleans the class variables
	 */
	public function reset() {
		$class_vars = get_class_vars(get_class($this));
		foreach ($class_vars as $name => $value) {
			if (substr($name, 0, 1) != '_') $this->$name = $value;
		}
	}
}
?>