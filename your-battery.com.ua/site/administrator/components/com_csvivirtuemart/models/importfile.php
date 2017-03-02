<?php
/**
* Import file model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: importfile.php 1118 2010-01-04 11:39:59Z Roland $
*/

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Import file Model
*
* @package CSVIVirtueMart
*/
class CsvivirtuemartModelImportfile extends JModel {
	
	/** @var integer for keeping track when the script started */
	private $_starttime = 0;
	
	/**
	* Sets the system limits to user defined values
	*
	* Sets the system limits to user defined values to allow for longer and
	* bigger uploaded files
	*/
	public function getSystemLimits() {
		/* Set the start time of the script */
		$this->_starttime = time();
		
		/* Get the logger */
		$csvilog = JRequest::getVar('csvilog');
		$template = JRequest::getVar('template');
		
		/* Set the user generated limits */
		$csvilog->AddMessage('debug', '<hr />');
		
		/* See if we need to use th new limits */
		if ($template->use_system_limits) {
			$csvilog->AddMessage('debug', 'Setting system limits:');
			/* Apply the new memory limits */
			$csvilog->AddMessage('debug', 'Setting max_execution_time to '.$template->max_execution_time.' seconds');
			@ini_set('max_execution_time', $template->max_execution_time);
			$csvilog->AddMessage('debug', 'Setting max_input_time to '.$template->max_input_time.' seconds');
			@ini_set('max_input_time', $template->max_input_time);
			$csvilog->AddMessage('debug', 'Setting memory_limit to '.$template->memory_limit.'M');
			@ini_set('memory_limit', $template->memory_limit.'M');
			$csvilog->AddMessage('debug', 'Setting post_max_size to '.$template->post_max_size.'M');
			@ini_set('post_max_size', $template->post_max_size.'M');
			$csvilog->AddMessage('debug', 'Setting upload_max_filesize to '.$template->upload_max_filesize.'M');
			@ini_set('upload_max_filesize', $template->upload_max_filesize.'M');
		}
	}
	
	/** 
	* Function to check if execution time is going to be passed. 
	*
	* Memory can only be checked if the function memory_get_usage is available.
	* If the function is not available always return true. This could lead to
	* out of memory failure.
	*
	* @todo Add memory_get_usage check to system check page
	* @see http://www.php.net/memory_get_usage
	* @return bool true|false true when limits are not reached|false when limit is reached
	*/
	public function getCheckLimits() {
		$csvilog = JRequest::getVar('csvilog');
		
		/* Check for maximum execution time */
		$timepassed = time() - $this->_starttime;
		
		if (($timepassed + 5) > ini_get('max_execution_time') && ini_get('max_execution_time') > 0) {
			$csvilog->AddStats('information', JText::_('MAXIMUM_EXECUTION_LIMIT_EXCEEDED').$timepassed.JText::_('seconds'));
			return false;
		}
		
		/* Check for maximum memory usage */
		if (!function_exists('memory_get_usage')) return true;
		else {
			/* Get the size of the statistics */
			$statslength = 0;
			if (isset($csvilog->stats)) {
				foreach ($csvilog->stats as $type => $value) {
					if (isset($value['message'])) $statslength += strlen($value['message']);
				}
			}
			$statslength = round($statslength/(1024*1024));
			
			/* Get the size of the debug message */
			$debuglength = round(strlen($csvilog->debug_message)/(1024*1024));
			
			/* Get the size of the active memory in use */
			$activelength = round(memory_get_usage()/(1024*1024));
			
			/* Combine memory limits */
			$totalmem = $activelength + $statslength + $debuglength;
			
			/* Set the memory limit */
			JRequest::setVar('maxmem', $totalmem);
			
			/* Check if we are passing the memory limit */
			if (($totalmem * 1.5) > (int)ini_get('memory_limit')) {
				$csvilog->AddStats('information', JText::_('MAXIMUM_MEMORY_LIMIT_EXCEEDED').' '.$totalmem.JText::_('MB'));
				return false;
			}
			
			 /* All is good return true */
			return true;
		}
	}
	
	/**
	*	Check user options for import
  	*/
  	public function getValidateImportChoices() {
		/* Get the template settings to see if we need a preview */
		$template = JRequest::getVar('template');
		
		/* Set debug on or off */
		JRequest::setVar('debug', $template->collect_debug_info);
		
		/* Overwrite existing data */
		$this->overwrite_existing_data = $template->overwrite_existing_data;
		
		/* Default value */
		if ($template->skip_default_value) JRequest::setVar('skip_default_value', true);
		else JRequest::setVar('skip_default_value', false);
		
		/* Skip first line */
		if ($template->skip_first_line) JRequest::setVar('currentline', JRequest::getVar('currentline')+1);
	}
	
	/**
	* Print out import details
	*/
	public function getImportDetails() {
		/* Get the logger */
		$csvilog = JRequest::getVar('csvilog');
		/* Get the template settings to see if we need a preview */
		$template = JRequest::getVar('template');
		
		$csvilog->AddMessage('debug', '<hr />');
		$csvilog->AddMessage('debug', JText::_('CSVI_VERSION_TEXT').JText::_('CSVI_VERSION'));
		if (function_exists('phpversion')) $csvilog->AddMessage('debug', 'PHP Version: '.phpversion());
		
		/* General settings */
		$csvilog->AddMessage('debug', 'General settings');
		/* Show which template is used */
		$csvilog->AddMessage('debug', 'Template name: '.$template->template_name);
		/* Auto detect delimiters */
		$auto_detect = ($template->auto_detect_delimiters) ? 'Yes' : 'No';
		$csvilog->AddMessage('debug', 'Auto-detect delimiters: '.$auto_detect);
		/* Check delimiter char */
		$csvilog->AddMessage('debug', 'Using delimiter: '.$template->field_delimiter);
		/* Check enclosure char */
		$csvilog->AddMessage('debug', 'Using enclosure: '.$template->text_enclosure);
		
		/* Show import settings */
		if (stristr($template->template_type, 'import')) {
			/* Show template type */
			$csvilog->AddMessage('debug', 'Template type: '.JText::_($template->template_type));
			
			/* Use column headers as configuration */
			$use_header = ($template->use_column_headers) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Use column headers for configuration: '.$use_header);
			
			/* Skip first line */
			$skip_first = ($template->skip_first_line) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Skip first line: '.$skip_first);
			
			/* Unpublish products before import */
			$unpublish = ($template->unpublish_before_import) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Unpublish before import: '.$unpublish);
			
			/* Overwrite existing data */
			$overwrite = ($template->overwrite_existing_data) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Overwrite existing data: '.$overwrite);
			
			/* Append categories */
			$append_cats = ($template->append_categories) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Append categories: '.$append_cats);
			
			/* Ignore non-existing products */
			$ignore_non_exist = ($template->ignore_non_exist) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Ignore non-existing products: '.$ignore_non_exist);
			
			/* Skip default value */
			$skip_default = ($template->skip_default_value) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Skip default value: '.$skip_default);
						
			/* Show preview */
			if ($template->show_preview && (!JRequest::getVar('was_preview', false))) {
				$csvilog->AddMessage('debug', 'Using preview');
			}
			else {
				if (JRequest::getVar('was_preview', false)) {
					$csvilog->AddMessage('debug', 'Preview used');
				}
				else $csvilog->AddMessage('debug', 'Not using preview');
			}
			
			/* Images */
			/* Automatic thumbnail creation */
			$auto_thumb = ($template->thumb_create) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Automatic thumbnail creation: '.$auto_thumb);
			
			/* Thumbnail format */
			$csvilog->AddMessage('debug', 'Thumbnail format: '.$template->thumb_extension);
			
			/* Thumbnail width x height */
			$csvilog->AddMessage('debug', 'Thumbnail width x height: '.$template->thumb_width.'x'.$template->thumb_height);
			
			/* Create image name */
			$create_name = ($template->auto_generate_image_name) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Create image name: '.$create_name);
			
			/* Image name format */
			$csvilog->AddMessage('debug', 'Image name format: '.$template->auto_generate_image_name_ext);
			
			/* Save images on server */
			$on_server = ($template->save_images_on_server) ? 'Yes' : 'No';
			$csvilog->AddMessage('debug', 'Save images on server: '.$auto_thumb);
			
		}
		/* Show export settings */
		else {
			
		}
		/* Show the file paths */
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_PATH_PRODUCT_IMAGES').' '.$template->file_location_product_images);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_PATH_CATEGORY_IMAGES').' '.$template->file_location_category_images);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_PATH_MEDIA').' '.$template->file_location_media);
		$csvilog->AddMessage('debug', JText::_('DEBUG_FILE_PATH_EXPORT_FILES').' '.$template->file_location_export_files);
	}
	
	/**
	* Unpublish products before import
	*/
	public function getUnpublishProducts() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		
		$q = "UPDATE #__vm_product SET product_publish = 'N'";
		$db->setQuery($q);
		if ($db->query()) $csvilog->AddMessage('debug', JText::_('PRODUCT_UNPUBLISH_BEFORE_IMPORT'));
		else $csvilog->AddMessage('debug', JText::_('COULD_NOT_UNPUBLISH_BEFORE_IMPORT'), true);
	}
	
	/**
	* Get the configuration fields the user wants to use
	*
	* The configuration fields can be taken from the uploaded file or from 
	* the database. Depending on the template settings
	*
	* @see Templates()
	* @return bool true|false true when there are config fields|false when there are no or unsupported fields
	*/
	public function getRetrieveConfigFields() {
		$template = JRequest::getVar('template');
		$csvilog = JRequest::getVar('csvilog');
		$supportedfields = array_flip(JRequest::getVar('supported_fields'));
		$columnheaders = JRequest::getVar('columnheaders');
		$db = JFactory::getDBO();
		$csv_fields = array();
		
		if ($template->use_column_headers) {
			/* The user has column headers in the file */
			JRequest::setVar('error_found', false);
			if ($columnheaders) {
				foreach ($columnheaders as $order => $name) {
					/* Trim the name in case the name contains any preceding or trailing spaces */
					$name = strtolower(trim($name));
					
					/* Check if the fieldname is supported */
					/* No special field checking for Product Type Names upload */
					if (array_key_exists($name, $supportedfields) || strtolower($template->template_type) == "producttypenamesimport") {
						$csvilog->AddMessage('debug', 'Field: '.$name);
						$csv_fields[$name]["name"] = $name;
						$csv_fields[$name]["order"] = $order;
						/* Get the default value for the fields */
						$q = "SELECT field_default_value 
							FROM #__csvivirtuemart_template_fields
							WHERE field_name = ".$db->Quote($name)."
							AND field_template_id = '".JRequest::getVar('template_id')."'";
						$db->setQuery($q);
						$csv_fields[$name]["default_value"] = $db->loadResult();
						$csv_fields[$name]["published"] = 1;
					}
					else {
						/* Check if the user has any field that is not supported */
						if (strlen($name) == 0) $name = JText::_('FIELD_EMPTY');
						/* See if we can find the delimiters ourselves */
						$text_delimiter = '';
						$field_delimiter = '';
						
						/* 1. Is the user using text enclosures */
						$first_char = substr($name, 0, 1);
						$pattern = '/[a-zA-Z_]/';
						$matches = array();
						preg_match($pattern, $first_char, $matches);
						if (count($matches) == 0) {
							/* User is using text delimiter */
							$text_delimiter = $first_char;
							
							/* 2. What field delimiter is being used */
							$match_next_char = strpos($name, $text_delimiter, 1);
							$field_delimiter = substr($name, $match_next_char+1, 1);
						}
						else {
							$totalchars = strlen($name);
							/* 2. What field delimiter is being used */
							for ($i = 0;$i <= $totalchars; $i++) {
								$current_char = substr($name, $i, 1);
								preg_match($pattern, $current_char, $matches);
								if (count($matches) == 0) {
									$field_delimiter = $current_char;
									$i = $totalchars;
								}
							}
						}
						$csvilog->AddStats('nosupport', $name.'<br />'.JText::_('FOUND_FIELD_DELIMITER').': '.$field_delimiter.'<br />'.JText::_('FOUND_TEXT_ENCLOSURE').': '.$text_delimiter.'<br />'.JText::_('Do they match your template settings?'));
					}
				}
				if (isset($csvilog->stats['nosupport']) && $csvilog->stats['nosupport']['count'] > 0) {
					$csvilog->AddMessage('info', JText::_('UNSUPPORTED_FIELDS').' '.$csvilog->stats['nosupport']['message']);
					JRequest::setVar('error_found', true);
					return false;
				}
				
				$csvilog->AddMessage('debug', 'Using file for configuration');
			}
			else {
				$csvilog->AddStats('incorrect', JText::_('NO_COLUMN_HEADERS_FOUND'));
				JRequest::setVar('error_found', true);
				return false;
			}
		}
		else {
			/* The user has column headers in the database */
			/* Get row positions of each element as set in csv table */
			$q = "SELECT id,field_name,field_order,field_column_header,field_default_value, published 
				FROM #__csvivirtuemart_template_fields 
				WHERE field_template_id = '".$template->template_id."'
				ORDER BY field_order";
			$db->setQuery($q);
			$rows = $db->loadAssocList();
			foreach ($rows as $id => $row) {
				if (!empty($row["field_column_header"])) $field_name = $row["field_column_header"];
				else $field_name = $row["field_name"];
				$csvilog->AddMessage('debug', 'Field: '.$field_name);
				$csv_fields[$field_name]["name"] = $field_name;
				$csv_fields[$field_name]["order"] = $row["field_order"];
				$csv_fields[$field_name]["default_value"] = $row["field_default_value"];
				$csv_fields[$field_name]["published"] = $row["published"];
			}
			$csvilog->AddMessage('debug', 'Use database for configuration');
		}
		/* Check if user is uploading related products */
		if (array_key_exists('related_products', $csv_fields)) {
			$this->RelatedProductsTempTable();
		}
		
		JRequest::setVar('csv_fields', $csv_fields);
		return true;
	}
	
	/**
	* Creates a temporary table to hold SKUs to relate
	*/
	private function RelatedProductsTempTable() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$q = "CREATE TEMPORARY TABLE csvi_import_related_products (
				product_sku VARCHAR(64) NOT NULL,
				related_sku TEXT NOT NULL
			)";
		$db->setQuery($q);
		if (!$db->query()) {
			$csvilog->AddMessage('debug', JText::_('DEBUG_TEMP_TABLE_RELATED_PRODUCTS'), true);
		}
	}
	
	/**
	* Drop the temporary table
	*/
	public function getDropRelatedProductsTempTable() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$db->setQuery('DROP TABLE IF EXISTS '.$db->nameQuote('csvi_import_related_products'));
		if (!$db->query()) {
			$csvilog->AddMessage('debug', JText::_('DEBUG_DROP_TEMP_TABLE_RELATED_PRODUCTS_NOK'), true);
		}
		else $csvilog->AddMessage('debug', JText::_('DEBUG_DROP_TEMP_TABLE_RELATED_PRODUCTS_OK'), true);
		JRequest::setVar('droprelated', true);
	}
	
	/**
	* Get the preview results
	*/
	public function getProcessData() {
		/* Set some variables */
		$data_preview = array();
		$processdata = true;
		$redirect = false;
		
		/* Load the log */
		$csvilog = JRequest::getVar('csvilog');
		
		/* Load the settings */
		$settings_model = new CsvivirtuemartModelSettings();
		
		/* Load the template */
		$template = JRequest::getVar('template');
		
		/* Load the file */
		$csvifile = JRequest::getVar('csvifile');
		
		/* Calculate line offset */
		$line_offset = 0;
		if ($template->skip_first_line) $line_offset++;
		
		/* Load the import routine */
		$classname = 'CsvivirtuemartModel'.$template->template_type;
		$routine = new $classname;
		
		/* Set a placeholder for the memory usage */
		$csvilog->AddMessage('debug', '{debugmem}');
		$csvilog->AddMessage('debug', '<hr />');
		
		/* Start processing data */
		while ($processdata) {
			/* If the number of lines is set to 0, do unlimited import */
			if ($settings_model->getSetting('import_nolines', 0) == 0 || JRequest::getBool('cron', false)) {
				$nolines = JRequest::getVar('currentline')+1;
			}
			else $nolines = $settings_model->getSetting('import_nolines')+$line_offset;
			if (JRequest::getVar('currentline') <= $nolines) {
				/* Load the data */
				JRequest::setVar('csvi_data', $csvifile->ReadNextLine());
				if (JRequest::getVar('csvi_data') == false) {
					/* Finish processing */
					$redirect = $this->finishProcess(false);
					$processdata = false;
				}
				else {
					if ($this->getCheckLimits()) {
						$csvilog->AddMessage('debug', str_ireplace('{currentline}', JRequest::getInt('currentline'), JText::_('DEBUG_PROCESS_LINE')));
						/* Start processing record */
						if ($routine->getStart()) {
							/* Check if the user wants us to show a preview */
							if ($template->show_preview) {
								if (JRequest::getInt('currentline') > $settings_model->getSetting('import_preview', 5)) {
									JRequest::setVar('data_preview', $data_preview);
									$processdata = false;
								}
								else {
									/* Update preview data */
									$csvi_data = JRequest::getVar('csvi_data', '', 'default', 'none', 2);
									$csv_fields = JRequest::getVar('csv_fields');
									
									foreach ($csv_fields as $fieldname => $value) {
										if (isset($routine->$fieldname)) $csvi_data[$csv_fields[$fieldname]["order"]] = $routine->$fieldname;
									}
									$data_preview[JRequest::getVar('currentline')] = $csvi_data;
								}
							}
							else {
								/* Now we import the rest of the records */
								$csvilog->setLinenumber((JRequest::getInt('currentline')+JRequest::getInt('totalline')));
								if (!JRequest::getBool('cron', false)) {
									echo '<script type="text/javascript">jQuery("#status", window.parent.document).html("Process line: '.(JRequest::getInt('currentline')+JRequest::getInt('totalline')).'");</script>';
								}
								$routine->getProcessRecord();
							}
						}
						$csvilog->AddMessage('debug', '<hr />');
						/* Increase linenumber and inform logger */
						JRequest::setVar('currentline', JRequest::getInt('currentline')+1);
					}
					else {
						/* Write out the memory usage for debug usage */
						if (JRequest::getVar('debug')) $csvilog->debug_message = str_replace('{debugmem}', 'Memory usage: '.JRequest::getVar('maxmem').' MB', $csvilog->debug_message);
						else $csvilog->debug_message = str_replace('{debugmem}', '', $csvilog->debug_message);
						
						/* Stop from processing any further, no time left */
						$processdata = false;
					}
				}
			}
			/* Prepare for page reload */
			else {
				/* Finish processing */
				$redirect = $this->finishProcess(true);
				
				/* Set the output page */
				if (!JRequest::getBool('reload', false)) JRequest::setVar('layout', 'importfile');
				
				/* Stop from processing any further, no time left */
				$processdata = false;
			}
		}
		/* Check if we are doing preview but less than 6 lines */
		if ($template->show_preview 
			&& JRequest::getVar('currentline') <= $settings_model->getSetting('import_preview') 
			&& !JRequest::getVar('error_found')) {
			JRequest::setVar('data_preview', $data_preview);
			$redirect = false;
		}
		
		/* Post Processing */
		if ($template->template_type == 'productimport') {
			$routine->getPostProcessing(); 
			/* Clean up  */
			if (JRequest::getVar('droprelated', false)) $this->getDropRelatedProductsTempTable();
		}
		
		/* Write out the memory usage for debug usage */
		if (JRequest::getVar('debug')) $csvilog->debug_message = str_replace('{debugmem}', 'Memory usage: '.JRequest::getVar('maxmem').' MB', $csvilog->debug_message);
		else $csvilog->debug_message = str_replace('{debugmem}', '', $csvilog->debug_message);
		
		return $redirect;
	}
	
	/**
	* Handle the redirect urls
	*/
	private function finishProcess($continue) {
		$template = JRequest::getVar('template');
		$csvifile = JRequest::getVar('csvifile');
		$csvilog = JRequest::getVar('csvilog');
		$redirect = false;
		
		/* Adjust the current line, since it is not processing */
		JRequest::setVar('currentline', JRequest::getInt('currentline')-1);
		
		/* Redirect to continue */
		if ($continue) {
			/* Get the current file position */
			$filepos = $csvifile->getFilePos();
			
			/* Close the file */
			$csvifile->CloseFile(false);
			/* The redirect url */
			$redirect = JURI::root().'administrator/index3.php?option=com_csvivirtuemart&controller=importfile&reload=1&template_id='.$template->template_id.'&selectfile=2&filepos='.$filepos.'&totalline='.(JRequest::getInt('currentline')+JRequest::getInt('totalline')).'&import_id='.$csvilog->getImportId().'&was_preview='.JRequest::getCmd('was_preview', '').'&csv_file='.urlencode(JRequest::getVar('csv_file'));
		}
		/* Redirect to finish */
		else {
			/* Load the settings */
			$settings_model = new CsvivirtuemartModelSettings();
			
			/* Close the file */
			if ($template->show_preview 
				&& JRequest::getVar('currentline') <= $settings_model->getSetting('import_preview') 
				&& !JRequest::getVar('error_found')) {
					$csvifile->CloseFile(false);
			}
			else $csvifile->CloseFile(true);
			
			/* The redirect url */
			$redirect = JURI::root().'administrator/index.php?option=com_csvivirtuemart&controller=import&task=finished&import_id='.$csvilog->getImportId();
			
			/* Set we are finished */
			JRequest::setVar('finished', true);
		}
		
		return $redirect;
	}
}
?>
