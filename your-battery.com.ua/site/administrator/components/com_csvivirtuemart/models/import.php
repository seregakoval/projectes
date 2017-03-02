<?php
/**
* Import model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: import.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Import Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelImport extends JModel {
	
	/** @var array Imported CSV fields */
	private $_csv_fields = null;
	/** @var array Imported data */
	private $_product_data = null;
	/** @var bool Whether or not to apply default values */
	private $_skip_default_value = null;
	/** @var mixed contains the current datafield value */
	private $_datafield = null;
	
	/**
	* Load some settings we need for the functions
	 */
	private function LoadSettings() {
		/* Load the settings */
		$this->_csv_fields = JRequest::getVar('csv_fields');
		$this->_product_data = JRequest::getVar('csvi_data', '', 'default', 'none', 2);
		$this->_skip_default_value = JRequest::getVar('skip_default_value');
	}
	
	/**
	* Get the product id, this is necessary for updating existing products
	*
	* @todo Reduce number of calls to this function
	* @return integer product_id is returned
	 */
	public function GetProductId() {
		$this->LoadSettings();
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		if (isset($this->_csv_fields["product_sku"])) {
			$q = "SELECT product_id
				FROM #__vm_product 
				WHERE product_sku = ".$db->Quote($this->_product_data[$this->_csv_fields["product_sku"]["order"]]);
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('Check to see if the product ID exists'), true);
			return $db->loadResult();
		}
		else if (isset($this->_csv_fields["product_id"])) {
			return $this->_product_data[$this->_csv_fields["product_id"]["order"]];
		}
		else return false;
	}
	
	/**
	* Get the product type ID, cannot do without it
	* 
	* The product_type_id is not auto incremental, therefore it needs to be
	* set manually
	 */
	public function GetProductTypeId() {
		$this->LoadSettings();
		$db = JFactory::getDBO();
		
		if (!isset($this->_csv_fields["product_type_id"]) && isset($this->_csv_fields["product_type_name"])) {
			$q = "SELECT product_type_id
				FROM ".$db->nameQuote('#__vm_product_type')."
				WHERE product_type_name = ".$db->Quote($this->_product_data[$this->_csv_fields["product_type_name"]["order"]]);
			$db->setQuery($q);
			$db->query();
			return $db->loadResult();
		}
		else return false;
	}
	
	/**
	* Validate CSV input data
	*
	* Checks if the field has a value, if not check if the user wants us to
	* use the default value
	*
	* @param string $fieldname the fieldname to validate
	* @return true|false returns validated value | return false if the column count does not match
	 */
	public function ValidateCsvInput($fieldname) {
		$this->LoadSettings();
		/* Check if the columns match */
		if (count($this->_csv_fields) != count($this->_product_data)) {
			$find = array('{configfields}', '{filefields}');
			$replace = array(count($this->_csv_fields), count($this->_product_data));
			if (!JRequest::getBool('incorrect_column_error', false)) {
				JError::raiseWarning(0, str_ireplace($find, $replace, JText::_('INCORRECT_COLUMN_COUNT')));
				JRequest::setVar('incorrect_column_error', true);
			}
			return false;
		}
		/* Columns match, validate */
		else {
			if (isset($this->_csv_fields[$fieldname])) {
				/* Check if the field has a value */
				if (array_key_exists($this->_csv_fields[$fieldname]["order"], $this->_product_data)
					&& strlen($this->_product_data[$this->_csv_fields[$fieldname]["order"]]) > 0) {
					return trim($this->_product_data[$this->_csv_fields[$fieldname]["order"]]);
				}
				/* Field has no value, check if we can use default value */
				else if (!$this->_skip_default_value) {
					return $this->_csv_fields[$fieldname]["default_value"];
				}
			}
			else return false;
		}
	}
	
	/**
	* Determine vendor ID
	*
	* Determine for which vendor we are importing product details.
	*
	* The default vendor is the one with the lowest vendor_id value
	*
	* @todo Add full vendor support
	 */
	public function GetVendorId() {
		$vendor_id = JRequest::getVar('vendor_id', false);
		
		if (!$vendor_id) {
			$db = JFactory::getDBO();
			$csvilog = JRequest::getVar('csvilog');
			
			/* User is uploading vendor_id */
			if (isset($this->_csv_fields["vendor_id"])) {
				$this->_datafield = $this->ValidateCsvInput('vendor_id');
				JRequest::setVar('vendor_id', $this->_datafield);
				return $this->_datafield;
			}
			/* User is not uploading vendor_id */
			/* First get the vendor with the lowest ID */
			$q = "SELECT MIN(vendor_id) AS vendor_id FROM #__vm_vendor";
			$db->setQuery($q);
			$min_vendor_id = $db->loadResult();
			
			if (isset($this->_csv_fields["product_sku"])) {
				$q = "SELECT IF (COUNT(vendor_id) = 0, ".$min_vendor_id.", vendor_id) AS vendor_id
					FROM #__vm_product 
					WHERE product_sku = ".$db->Quote($this->_product_data[$this->_csv_fields["product_sku"]["order"]]);
				$db->setQuery($q);
				
				$csvilog->AddMessage('debug', JText::_('Check to see if the vendor ID exists'), true);
				/* Existing vendor_id */
				$vendor_id = $db->loadResult();
				JRequest::setVar('vendor_id', $vendor_id);
				return $vendor_id;
			}
			/* No product_sku uploaded */
			else {
				JRequest::setVar('vendor_id', $min_vendor_id);
				return $min_vendor_id;
			}
		}
		return $vendor_id;
	}
	
	/**
	*	Gets the default Shopper Group ID
	* @todo add error checking
  	* */
	public function GetDefaultShopperGroupID() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		$vendor_id = $this->GetVendorId();
		
		$q = "SELECT shopper_group_id FROM #__vm_shopper_group ";
		$q .= "WHERE `default`='1' and vendor_id='".$vendor_id."'";
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('DEBUG_GET_DEFAULT_SHOPPER_GROUP'), true);
		return $db->loadResult();
	}
	
	/**
	* Gets the default manufacturer ID
	* As there is no default manufacturer, we take the first one
  	* */
	public function GetDefaultManufacturerID() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		/* Check if product already has a manufacturer link */
		if (isset($this->_csv_fields["product_sku"])) {
			$q = "SELECT manufacturer_id FROM #__vm_product_mf_xref m
				LEFT JOIN #__vm_product p
				ON m.product_id = p.product_id
				WHERE product_sku = ".$db->Quote($this->_product_data[$this->_csv_fields['product_sku']['order']]);
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('DEBUG_GET_MANUFACTURER_ID_SKU'), true);
			$mf_id = $db->loadResult();
		}
		else if (isset($this->_csv_fields["product_id"])) {
			$q = "SELECT manufacturer_id FROM #__vm_product_mf_xref
				WHERE product_id = ".$db->Quote($this->_product_data[$this->_csv_fields['product_id']['order']]);
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('DEBUG_GET_MANUFACTURER_ID_ID'), true);
			$mf_id = $db->loadResult();
		}
		
		/* Check if we have a result */
		if (!$mf_id) {
			$q = "SELECT manufacturer_id FROM #__vm_manufacturer LIMIT 1 ";
			$db->setQuery($q);
			$csvilog->AddMessage('debug', JText::_('DEBUG_GET_DEFAULT_MANUFACTURER_ID'), true);
			return $db->loadResult();
		}
		else return $mf_id;
	}
	
	/**
	* Get a template ID
	 */
	public function getTemplateId() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT template_id
			FROM #__csvivirtuemart_templates
			WHERE template_name = ".$db->Quote($this->_product_data[$this->_csv_fields['template_name']["order"]]);
		$db->setQuery($q);
		$csvilog->AddMessage('debug', JText::_('DEBUG_GET_TEMPLATE_ID'), true);
		if ($db->query()) return $db->loadResult();
		else return false;
	}
	
	/**
	* Create a thumbnail from the image file on import
	*
	* A thumbnail will also be created if the thumbnail file already exists
	*
	* @param string name of the image to create a thumbnail from (product_full_image)
	* @see Img2Thumb()
	* @todo option in template to create a different file extension
	 */
	public function ProcessImage($file_name_original, $file_name_thumb, $file_location) {
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');
		$template = JRequest::getVar('template');
		$csvilog = JRequest::getVar('csvilog');
		$file_details = array();
		
		/* Check if the thumbsize is greater than 0 */
		if ($template->thumb_width > 0 && $template->thumb_height > 0) {
		
			/* Get the file details */
			$file_details = $this->FileDetails($file_name_original, $file_name_thumb, $file_location);
			
			if ($file_details) {
				/* Check if we are dealing with a remote file */
				if (substr($file_name_original, 0, 4) == 'http') $file_remote = true;
				else $file_remote = false;
				
				/* Check if the file is present */
				if ($template->collect_debug_info) {
					$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_PATH').' '.$file_details['file_path']);
					$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME').' '.$file_details['file_name']);
					$csvilog->AddMessage('debug', JText::_('DEBUG_CHECK_FILE_EXISTS').' '.$file_details['file_path'].DS.$file_details['file_name']);
				}
			
				/* Set the value the file exists */
				$file_exists = true;
				
				/* Let's see if we need to make a thumbnail */
				if ($file_details['file_is_image']) {
					/* Resize the image */
					if (strtolower($template->thumb_extension) != 'none') $file_out_extension = $template->thumb_extension;
					else $file_out_extension = $file_details['file_extension'];
					$thumb_file_name = basename($file_details['clean_file_name_thumb'], ".".$file_details['file_extension']).".".$file_out_extension;
					$thumb_file_details = array();
					$thumb_file_details['file'] = $file_details['file_path'].DS.$file_details['file_name'];
					$thumb_file_details['file_extension'] = $file_details['file_extension'];
					$find_delim = array("/", "\\");
					if ($template->template_type != 'productfilesimport') {
						$thumb_file_details['rename'] = 0;
						$thumb_file_details['file_out'] = str_replace($find_delim, DS, $file_location).DS.dirname($file_details['clean_file_name_thumb']).DS.$thumb_file_name;
					}
					else {
						$thumb_file_details['rename'] = 1;
						$thumb_file_details['file_out'] = str_replace($find_delim, DS, $file_location).DS.dirname($file_details['clean_file_name_thumb']).DS.'resized'.DS.$thumb_file_name;
					}
					$thumb_file_details['maxsize'] = 0;
					$thumb_file_details['bgred'] = 255;
					$thumb_file_details['bggreen'] = 255;
					$thumb_file_details['bgblue'] = 255;
					$thumb_file_details['file_out_width'] = $template->thumb_width;
					$thumb_file_details['file_out_height'] = $template->thumb_height;
					$thumb_file_details['file_out_extension'] = $file_out_extension;
					
					/* We need to resize the image and Save the new one (all done in the constructor) */
					if ($template->collect_debug_info) $csvilog->AddMessage('debug', JText::_('Creating a thumbnail').' '.$thumb_file_details['file_out']);
					$new_img = new ImageConverter($thumb_file_details);
					
					/* Check if an image was created */
					if ($new_img) {
						/* Reset the file_out with the actual created file */
						$thumb_file_details['file_out'] = $new_img->file_out;
						
						/* Get the details of the thumb image */
						if (JFile::exists($thumb_file_details['file_out'])) {
							if ($template->collect_debug_info) $csvilog->AddMessage('debug', JText::_('Thumbnail has been created'));
							$file_details['file_thumb_name'] = 'resized'.DS.$thumb_file_name;
							$file_details_thumb = getimagesize($thumb_file_details['file_out']);
							if ($file_details_thumb) {
								$image_thumb_width = $file_details_thumb[0];
								$image_thumb_height = $file_details_thumb[1];
							}
							else {
								$image_thumb_width = 0;
								$image_thumb_height = 0;
							}
							
							/* Add to the array */
							$file_details['file_thumb_width'] = $image_thumb_width;
							$file_details['file_thumb_height'] = $image_thumb_height;
						}
						else {
							$csvilog->AddMessage('debug', JText::_('Thumbnail could not be created'));
							return false;
						}
					}
					else {
						$csvilog->AddMessage('debug', JText::_('Thumbnail could not be created'));
						return false;
					}
					
					/* Remove the downloaded file */
					if ($file_remote && !$template->save_images_on_server) JFile::delete($file_details['file_path'].DS.$file_details['file_name']);
				}
				else {
					$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_IS_NOT_IMAGE'));
				}
				/* Return an array with file details */
				return $file_details;
			}
			else {
				if ($template->collect_debug_info) $csvilog->AddMessage('debug', JText::_('FILE_DOES_NOT_EXIST_NOTHING_TO_DO').' '.$file_name_original);
				$csvilog->AddStats('nofiles', JText::_('FILE_DOES_NOT_EXIST_NOTHING_TO_DO').' '.$file_name_original);
				return false;
			}
		}
		else {
			if ($template->collect_debug_info) $csvilog->AddMessage('debug', JText::_('Thumbnail size too small.'));
			$csvilog->AddStats('incorrect', JText::_('Thumbnail size too small.'));
			return false;
		}
	}
	
	/**
	* Collect information about a file
	 */
	public function FileDetails($file_name_original, $file_name_thumb, $file_location) {
		$template = JRequest::getVar('template');
		$csvilog = JRequest::getVar('csvilog');
		
		/* Get the image handling functions */
		$mime_type_detect = new MimeTypeDetect();
		
		/* What data did we get? */
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_LOCATION').' '.$file_location);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME_ORIGINAL').' '.$file_name_original);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME_THUMB').' '.$file_name_thumb);
		
		/* Check if the first character of the image is either a forward or backslash */
		$findstr = '\/';
		if (strstr($findstr, substr($file_name_original, 0, 1))) {
			$file_name_original = substr($file_name_original, 1);
		}
		
		if (strstr($findstr, substr($file_name_thumb, 0, 1))) {
			$file_name_thumb = substr($file_name_thumb, 1);
		}
		
	 	/* Remove the base of the filename for VirtueMart */
		$file_name_original = str_replace(JPATH_SITE, '', $file_name_original);
		$file_name_thumb = str_replace(JPATH_SITE, '', $file_name_thumb);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME_ORIGINAL').' '.$file_name_original);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME_THUMB').' '.$file_name_thumb);
		
		/* Set all slashes in the same direction */
		$find_delim = array("/", "\\");
		$clean_file_name_original = str_replace($find_delim, DS, $file_name_original);
		$clean_file_name_thumb = str_replace($find_delim, DS, $file_name_thumb);
		$file_location = str_replace($find_delim, DS, $file_location);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_LOCATION').' '.$clean_file_name_thumb);
		$csvilog->AddMessage('debug', JText::_('DEBUG_CLEAN_FILE_NAME_ORIGINAL').' '.$clean_file_name_original);
		$csvilog->AddMessage('debug', JText::_('DEBUG_CLEAN_FILE_NAME_THUMB').' '.$clean_file_name_thumb);
		
		/* Get the file details */
		$file_name = str_ireplace($file_location, '', $clean_file_name_original);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_NAME').' '.$file_name);
		
		if (substr($file_name_original, 0, 4) == 'http') {
			$file_name = basename($file_name_original);
			if ($template->save_images_on_server) $file_path = $file_location;
			else $file_path = JPATH_CACHE.DS.'csvi';
			/* Get the file first */
			if ($template->collect_debug_info) {
				$csvilog->AddMessage('debug', JText::_('Retrieving external file:').' '.$file_name_original.'<br />'.JText::_('SAVING_REMOTE_FILE_TO_LOCAL_FILE').' '.$file_path.DS.$file_name);
			}
			JFile::write($file_path.DS.$file_name, JFile::read($file_name_original));
		}
		
		/* Get the details */
		$csvilog->AddMessage('debug', JText::_('DEBUG_CHECK_FILE_EXISTS').$file_location.DS.$file_name);
		if (JFile::exists($file_location.DS.$file_name)) {
			/* Get the mime type */
			$file_mimetype = $mime_type_detect->FindMimeType($file_location.DS.$file_name);
			
			/* Check if the filename has an extension */
			$file_parts = pathinfo($file_name);
			if (array_key_exists('extension', $file_parts)) $file_extension = $file_parts['extension'];
			else $file_extension = '';
			
			/* Check if file is image */
			$file_is_image = $mime_type_detect->CheckImage($file_mimetype);
			
			if ($file_is_image) {
				/* See if we can add an extension based on mime-type */
				if (empty($file_extension)) {
					switch ($file_mimetype) {
						case 'image/jpeg':
							$file_extension = 'jpg';
							break;
						case 'image/gif':
							$file_extension = 'gif';
							break;
						case 'image/png':
							$file_extension = 'png';
							break;
						case 'image/bmp':
							$file_extension = 'bmp';
							break;
					}
					/* Check if the file exists, if so we need to delete the old one */
					if (file_exists($file_location.DS.$file_name.'.'.$file_extension)) {
						JFile::delete($file_location.DS.$file_name.'.'.$file_extension);
					}
					/* Rename the image file */
					JFile::move($file_location.DS.$file_name, $file_location.DS.$file_name.'.'.$file_extension);
					
					/* Fix the filename */
					$file_name .= '.'.$file_extension;
				}
				
				list($width, $height) = getimagesize($file_location.DS.$file_name);
				
				/* Calculate thumbnail sizes */
				$maxX = $template->thumb_width;
				$maxY = $template->thumb_height;
				$file_out_width = $template->thumb_width;
				$file_out_height = $template->thumb_height;
				
				/* Make sure all values are above 0, otherwise we cannot calculate with it */
				if ($width > 0 && $height > 0 && $file_out_width > 0 && $file_out_height > 0) {
					if ($width < $height) {
						$file_out_width = $file_out_height * ($width/$height);
					}
					else {
						$file_out_height = $file_out_width / ($width/$height);
					}
					while ($file_out_width < 1 || $file_out_height < 1) {
						$file_out_width *= 2;
						$file_out_height *= 2;
					}
				}
			}
			else {
				$width = 0;
				$height = 0;
				$file_out_width = 0;
				$file_out_height = 0;
			}
			
			$file_details['file_name'] = $file_name;
			$file_details['file_extension'] = $file_extension;
			$file_details['file_mimetype'] = $file_mimetype;
			$file_details['file_is_image'] = $file_is_image;
			$file_details['file_image_height'] = $height;
			$file_details['file_image_width'] = $width;
			$file_details['file_path'] = $file_location;
			$file_details['clean_file_name_original'] = $clean_file_name_original;
			$file_details['clean_file_name_thumb'] = $clean_file_name_thumb;
			$file_details['file_thumb_width'] = $file_out_width;
			$file_details['file_thumb_height'] = $file_out_height;
			
			return $file_details;
		}
		else return false;
	}
	
	
	/**
	* Get the shopper group id
	*
	* Only get the shopper group id when the shopper_group_name is set
	*
	* @see $shopper_group_name
	 */
	public function ShopperGroupName($shopper_group_name) {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "SELECT shopper_group_id 
			FROM #__vm_shopper_group 
			WHERE shopper_group_name = ".$db->Quote($shopper_group_name);
		$db->setQuery($q);
		$shopper_group_id = $db->loadResult();
		$csvilog->AddMessage('debug', JText::_('DEBUG_SHOPPER_GROUP_NAME'), true);
		return $shopper_group_id;
	}
	
	/**
	* Get the product price
	*
	* Replace commas with periods for correct DB insertion of the prices
	 */
	public function ToPeriod($value) {
		return str_replace(",", ".", $value);
	}
	
	/**
	* Clean up after the user has cancelled the import
	*/
	public function getImportCleanup() {
		$user = JFactory::getUser();
		$details = array();
		/* Get the user ID */
		$details['userid'] = $user->id;
		/* Create GMT timestamp */
		jimport('joomla.utilities.date');
		$jnow = new JDate(time());
		$details['logstamp'] = $jnow->toMySQL();
		/* Set action if it is import or export */
		$details['action'] = 'import';
		/* Type of action */
		$details['action_type'] = JRequest::getVar('action_type');
		/* Name of template used */
		$details['template_name'] = JRequest::getVar('template_name');
		/* Get the number of records */
		$details['records'] = 0;
		/* Get the import ID */
		$details['import_id'] = JRequest::getInt('import_id');
		/* Get the import filename */
		$details['file_name'] = JRequest::getVar('filename');
		
		/* Get the database connector */
		$log = $this->getTable('csvi_logs');
		$log->bind($details);
		$log->store();
		
		/* Store the log details */
		$db = JFactory::getDBO();
		$q = 'INSERT INTO `#__csvivirtuemart_log_details` ( `id`,`log_id`,`line`,`description`,`result`,`status` ) VALUES ';
		$q .= "(0, ".$log->id.", 0, ".$db->Quote(JText::_('IMPORT_CANCELLED')).", ".$db->Quote(JText::_('NOTICE')).", 'information')";
		$db->setQuery($q);
		$db->query();
		return true;
	}
}
?>