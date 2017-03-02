<?php
/**
* Export File model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: exportfile.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Export File Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelExportfile extends JModel {
	
	/** @var string Category separator */
	private $_catsep = null;
	
	/** @var array Holds the replacement values */
	private $_replacements = false;
	
	/**
	* Initialise
	 */
	public function __construct() {
		parent::__construct();
		
		/* Allow big SQL selects */
		$db = JFactory::getDBO();
		$db->setQuery("SET OPTION SQL_BIG_SELECTS=1");
		$db->query();
	}
	
	/**
	* Get the export filename
	*
	* @return string Returns the filename of the exported file
	 */
	public function getExportFilename() {
		$template = JRequest::getVar('template');
		$exportto = JRequest::getVar('exportto');
		$csvilog = JRequest::getVar('csvilog');
		
		/* Check if the export is limited, if so add it to the filename */
		/* Check if both values are greater than 0 */
		if ((JRequest::getInt('recordstart') > 0) && (JRequest::getInt('recordend') > 0)) {
			/* We have valid limiters, add the limit to the filename */
			$filelimit = "_".JRequest::getInt('recordend').'_'.((JRequest::getInt('recordend')-1)+JRequest::getInt('recordstart'));
		}
		else $filelimit = '';
		
		/**
		* Set the filename to use for export
		*
		* If an export filename is set in the template, this will override
		* any other settting.
		 */
		/* Use the name from the template */
		if (!empty($template->export_filename)) {
			/* See if we are emailing the file */
			if ($template->export_email) {
				$localfile = JPATH_CACHE.DS.$template->export_filename;
			}
			/* Use the file location from the template if saving to server */
			else if (!empty($template->file_location_export_files) && ($exportto == 'tofile')) {
				$localfile = $template->file_location_export_files.DS.$template->export_filename;
			}
			/* Use the file location from the export page if saving the file to server but there is no location in the template */
			else if ($exportto == 'tofile') $localfile = JRequest::getVar('localfile').DS.$template->export_filename;
			/* Only use filename when downloading the file */
			else $localfile = $template->export_filename;
		}
		else if ($exportto == 'tofile' && JRequest::getVar('localfile', false)) {
			$localfile = str_replace("\\", DS, JRequest::getVar('localfile')).DS.
							"CSVI_VM_Export_".$template->template_type.'_'.date("j-m-Y_H.i").
							$filelimit.".".$template->export_type;
		}
		else {
			$localfile = '';
			if ($exportto == 'toemail') $localfile = JPATH_CACHE.DS;
			/* Check if there is a path we can use */
			if (!empty($template->file_location_export_files) && ($exportto == 'tofile')) {
				$localfile .= $template->file_location_export_files.DS;
			}
			$localfile .= "CSVI_VM_Export_".$template->template_name.'_'.date("j-m-Y_H.i").$filelimit.".".$template->export_type;
		}
		
		/* Set the filename */
		$csvilog->setFilename($localfile);
		
		/* Return the filename */
		return $localfile;
	}
	
	/**
	* Get the fiels to use for the export
	*
	* @return array Returns an array of required fields and default field values
	 */
	public function getExportFields() {
		$db = JFactory::getDBO();
		$template = JRequest::getVar('template');
		
		/* Get the field configuration */
		/* Get row positions of each element as set in csv table */
		$q = "SELECT * FROM #__csvivirtuemart_template_fields
			WHERE field_template_id = ".$template->template_id."
			AND published = 1
			ORDER BY field_order";
		$db->setQuery($q);
		$rows = $db->loadObjectList();
		
		$required_fields = array();
		$default_values = array();
		foreach ($rows as $id => $row) {
			/* Collect the required fields */
			if ($template->export_type == 'xml') {
				if (!empty($row->field_column_header)) {
					$required_fields[$row->id]->column_header = str_replace(" ", "", $row->field_column_header);
					$required_fields[$row->id]->field_name = $row->field_name;
				}
				else {
					$required_fields[$row->id]->column_header = str_replace(" ", "", $row->field_name);
					$required_fields[$row->id]->field_name = $row->field_name;
				}
			}
			else {
				if (!empty($row->field_column_header)) {
					$required_fields[$row->id]->column_header = $row->field_column_header;
					$required_fields[$row->id]->field_name = $row->field_name;
				}
				else {
					$required_fields[$row->id]->column_header = $row->field_name;
					$required_fields[$row->id]->field_name = $row->field_name;
				}
			}
			
			/* Collect the default values */
			$required_fields[$row->id]->default_value = $row->field_default_value;
			$required_fields[$row->id]->field_id = $row->id;
			
			/* Set if it needs to be replaced */
			$required_fields[$row->id]->replace = $row->field_replace;
		}
		
		/* Return the required and default values */
		return $required_fields;
	}
	
	/**
	* Search through the export fields if a certain field is being exported
	 */
	public function searchExportFields($fieldname, $export_fields) {
	 	foreach ($export_fields as $column_id => $field) {
	 		if ($field->field_name == $fieldname) return true;
	 	}
	 	return false;
	}
	
	/**
	* Adds a limit to a query
	*
	* @return string|NULL the limit statement is returned if there is a record start and end else nothing is retrned
	 */
	public function ExportLimit() {
		$recordstart = JRequest::getVar('recordstart', false);
		$recordend = JRequest::getVar('recordend', false);
		/* Check if the user only wants to export some products */
		if ($recordstart && $recordend) {
			/* Check if both values are greater than 0 */
			if (($recordstart > 0) && ($recordend > 0)) {
				/* We have valid limiters, add the limit to the query */
				/* Recordend needs to have 1 deducted because MySQL starts from 0 */
				return ' LIMIT '.($recordend-1).','.$recordstart;
			}
		}
	}
	
	/**
	* Remove trailing 0
	*
	* @return int returns a product price without trailing 0
	* @todo add user setting for number of decimals
	 */
	public function ProductPrice($product_price) {
		if ($product_price) {
			if (strstr('.', $product_price)) {
				list($number, $decimals) = explode('.', $product_price);
				if (strlen($decimals) > 2) {
					for ($i=1;$i<4;$i++) {
						if (substr($decimals, -1) == 0) $decimals = substr($decimals, 0, -1);
						else $i = 4;
					}
				}
				$product_price = $number.'.'.$decimals;
			}
		}
		return $product_price;
	}
	
	/**
	* Get the flypage for a product
	*
	* @return string returns the name of the flypage
	 */
	public function GetFlypage($product_id) {
		$db = JFactory::getDBO();
		$q =  "SELECT `#__vm_category`.`category_flypage`
			FROM `#__vm_product`
			LEFT JOIN `#__vm_product_category_xref` 
			ON `#__vm_product_category_xref`.`product_id` = `#__vm_product`.`product_id`
			LEFT JOIN `#__vm_category` 
			ON `#__vm_product_category_xref`.`category_id` = `#__vm_category`.`category_id`
			WHERE `#__vm_product`.`product_id`='".$product_id."'";
		$db->setQuery($q);
		$flypage = $db->loadResult();
		if (is_null($flypage)) {
			/* There is no flypage found let's use the VirtueMart config settings */
			$vm_config = new CsviVmConfig();
			$flypage = $vm_config->getSetting('flypage');
			if (!$flypage) return 'shop.flypage.tpl';
			else return $flypage;
		}
		else return $flypage;
	}
	
	/**
	* Get the category ID for a product
	*
	* @return int returns the category ID
	 */
	public function GetCategoryId($product_id) {
		$db = JFactory::getDBO();
		$q = "SELECT category_id FROM #__vm_product_category_xref 
			WHERE product_id = '".$product_id."' LIMIT 1";
		$db->setQuery($q);
		return $db->loadResult();
	}
	
	/**
	* Add a field to the output
	*
	* @param $data string Data to output
	* @param $fieldname string Name of the field currently being processed
	* @param $column_header string Name of the column
	* @param $cdata boolean true to add cdata tag for XML|false not to add it
	* @return string containing the field for the export file
	 */
	function AddExportField($data, $fieldname, $column_header, $cdata=false) {
		$template = JRequest::getVar('template');
		$exportclass = JRequest::getVar('exportclass');
		
		/* Clean up the data by removing linebreaks */
		$find = array("\r\n", "\r", "\n");
		$replace = array('','','');
		$data = str_ireplace($find, $replace, $data);
		
		if ($template->export_type == 'xml' || $template->export_type == 'html') {
			return $exportclass->ContentText($data, $column_header, $fieldname, $cdata);
		}
		else {
			$data = str_replace($template->text_enclosure, $template->text_enclosure.$template->text_enclosure, $data); 
			return $template->text_enclosure.$data.$template->text_enclosure.$template->field_delimiter;
		}
	}
	
	/**
	* Get the pipe delimited category path of a product
	*
	* @name GetCategoryPathId
	* @author Rolandd
	* @param int $product_id
	* @returns String category_path
	*/
	public function GetCategoryPathId($product_id) {
		$db = JFactory::getDBO();
		$q = "SELECT category_id FROM #__vm_product_category_xref WHERE product_id = ".$product_id;
		$db->setQuery($q);
		return implode('|', $db->loadResultArray());
	}
	
	/**
	* Get the slash delimited category path of a product
	*
	* @name GetCategoryPath
	* @author soeren
	* @param int $product_id
	* @returns String category_path
	*/
	public function GetCategoryPath($product_id, $name=false) {
		$db = JFactory::getDBO();
		
		/* Load the category separator */
		if (is_null($this->_catsep)) {
			$settings = new CsvivirtuemartModelSettings();
			$paramsdata = $settings->getSettings();
			$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'config.xml';
			$params = new JParameter( $paramsdata, $paramsdefs );
			$this->_catsep = $params->get('category_separator', '/');
		}
		
		$q = "SELECT #__vm_product.product_id, #__vm_product.product_parent_id, category_name,#__vm_category_xref.category_parent_id "
		."FROM #__vm_category, #__vm_product, #__vm_product_category_xref,#__vm_category_xref "
		."WHERE #__vm_product.product_id='".$product_id."' "
		."AND #__vm_category_xref.category_child_id=#__vm_category.category_id "
		."AND #__vm_category_xref.category_child_id = #__vm_product_category_xref.category_id "
		."AND #__vm_product.product_id = #__vm_product_category_xref.product_id";
		$db->setQuery($q);
		$rows = $db->loadObjectList();
		$k = 1;
		$category_path = "";
		
		foreach ($rows as $row) {
			$category_name = array();
			
			/** Check for product or item* */
			if ( $row->category_name ) {
				$category_parent_id = $row->category_parent_id;
				$category_name[] = $row->category_name;
			}
			else {
				/** must be an item
				* So let's search for the category path of the
				* parent product 
				*/
				$q = "SELECT product_parent_id FROM #__vm_product WHERE product_id='".$product_id."'";
				$db->setQuery($q);
				$ppi = $db->loadResult();

				$q  = "SELECT #__vm_product.product_id, #__vm_product.product_parent_id, category_name,#__vm_category_xref.category_parent_id "
				."FROM #__vm_category, #__vm_product, #__vm_product_category_xref,#__vm_category_xref "
				."WHERE #__vm_product.product_id='".$ppi."' "
				."AND #__vm_category_xref.category_child_id=#__vm_category.category_id "
				."AND #__vm_category_xref.category_child_id = #__vm_product_category_xref.category_id "
				."AND #__vm_product.product_id = #__vm_product_category_xref.product_id";
				$db->setQuery($q);
				$cat_details = $db->loadObject();
				$category_parent_id = $cat_details->category_parent_id;
				$category_name[] = $cat_details->category_name;
			}
			if( $category_parent_id == "") $category_parent_id = "0";

			while ($category_parent_id != "0") {
				$q = "SELECT category_name, category_parent_id "
				."FROM #__vm_category, #__vm_category_xref "
				."WHERE #__vm_category_xref.category_child_id=#__vm_category.category_id "
				."AND #__vm_category.category_id='".$category_parent_id."'";
				$db->setQuery($q);
				$cat_details = $db->loadObject();
				$category_parent_id = $cat_details->category_parent_id;
				$category_name[] = $cat_details->category_name;
			}
			if (sizeof($category_name) > 1 && !$name) {
				for ($i = sizeof($category_name)-1; $i >= 0; $i--) {
					$category_path .= $category_name[$i];
					if( $i >= 1) $category_path .= $this->_catsep;
				}
			}
			else $category_path .= $category_name[0];

			if( $k++ < sizeof($rows) )
			$category_path .= "|";
		}
		return $category_path;
	}
	
	/**
	* Creates the category path
	 */
	function CreateCategoryPath() {
		$db = JFactory::getDBO();
		$catpaths = array();
		
		/* Load the category separator */
		if (is_null($this->_catsep)) {
			$settings = new CsvivirtuemartModelSettings();
			$paramsdata = $settings->getSettings();
			$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'config.xml';
			$params = new JParameter( $paramsdata, $paramsdefs );
			$this->_catsep = $params->get('category_separator', '/');
		}
		
		while (JRequest::getVar('catid') > 0) {
			$q = "SELECT category_parent_id, category_name FROM #__vm_category_xref x, #__vm_category c
				WHERE x.category_child_id = c.category_id
				AND category_child_id = ".JRequest::getVar('catid');
			$db->setQuery($q);
			$path = $db->loadObject();
			$catpaths[] = trim($path->category_name);
			JRequest::setVar('catid', $path->category_parent_id);
		}
		$catpaths = array_reverse($catpaths);
		return implode($this->_catsep, $catpaths);
	}
	
	public function getOutputStart() {
		$template = JRequest::getVar('template');
		$csvilog = JRequest::getVar('csvilog');
		$exportfilename = JRequest::getVar('exportfilename');
		
		switch(JRequest::getVar('exportto')) {
			case 'todownload':
				if (ereg('Opera(/| )([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
					$UserBrowser = "Opera";
				}
				elseif (ereg('MSIE ([0-9].[0-9]{1,2})', $_SERVER['HTTP_USER_AGENT'])) {
					$UserBrowser = "IE";
				} else {
					$UserBrowser = '';
				}
				$mime_type = ($UserBrowser == 'IE' || $UserBrowser == 'Opera') ? 'application/octetstream' : 'application/octet-stream';

				/* Clean the buffer */
				while( @ob_end_clean() );
		
				header('Content-Type: ' . $mime_type);
				header('Content-Encoding: UTF-8');
				header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		
				if ($UserBrowser == 'IE') {
					header('Content-Disposition: inline; filename="'.$exportfilename.'"');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
				} else {
					header('Content-Disposition: attachment; filename="'.$exportfilename.'"');
					header('Pragma: no-cache');
				}
				break;
			case 'tofile':
				jimport('joomla.filesystem.folder');
				
				/* Check if the folder exists */
				if (!JFolder::exists(dirname($exportfilename))) {
					if (!JFolder::create(dirname($exportfilename))) {
						$csvilog->AddStats('incorrect', JText::_('Cannot create folder').'  '.dirname($exportfilename));
						return false;
					}
				}
				
				/* open the file for writing */
				$handle = fopen($exportfilename, 'w+');
				if (!$handle) {
					$csvilog->AddStats('incorrect', JText::_('Cannot open file').'  '.$exportfilename);
					return false;
				}
				/* Let's make sure the file exists and is writable first. */
				if (is_writable($exportfilename)) {
				    JRequest::setVar('handle', $handle);
				    return true;
				} 
				else {
					$csvilog->AddStats('incorrect', JText::_('The file is not writable').' '.$exportfilename);
					return false;
				}
				break;
			case 'toemail':
				/* open the file for writing */
				$handle = fopen($exportfilename, 'w+');
				if (!$handle) {
					$csvilog->AddStats('incorrect', JText::_('Cannot open file').'  '.$exportfilename);
					return false;
				}
				/* Let's make sure the file exists and is writable first. */
				if (is_writable($exportfilename)) {
				    JRequest::setVar('handle', $handle);
				    return true;
				} 
				else {
					$csvilog->AddStats('incorrect', JText::_('The file is not writable').' '.$exportfilename);
					return false;
				}
				break;
		}
		
	}
	
	/**
	* Write the output to download or to file
	 */
	public function writeOutput($contents) {
		$csvilog = JRequest::getVar('csvilog');
		$exportfilename = JRequest::getVar('exportfilename');
		
		switch(JRequest::getVar('exportto')) {
			case 'todownload':
				echo $contents;
				break;
			case 'tofile':
			case 'toemail':
				if (fwrite(JRequest::getVar('handle'), $contents) === FALSE) {
					$csvilog->AddStats('incorrect', JText::_('Cannot write to file').' '.$exportfilename);
				   return false;
				}
				break;
		}
	}
	
	public function getOutputEnd() {
		$csvilog = JRequest::getVar('csvilog');
		$template = JRequest::getVar('template');
		$exportfilename = JRequest::getVar('exportfilename');
		
		switch(JRequest::getVar('exportto')) {
			case 'todownload':
				exit();
				break;
			case 'tofile':
				$csvilog->AddStats('information', "The file ".$exportfilename." has been created");
				fclose(JRequest::getVar('handle'));
				break;
			case 'toemail':
				jimport('joomla.filesystem.file');
				fclose(JRequest::getVar('handle'));
				$this->loadMailer();
				/* Add the email address */
				$this->mailer->AddAddress($template->export_email_addresses);
				$this->mailer->AddCC($template->export_email_addresses_cc);
				$this->mailer->AddBCC($template->export_email_addresses_bcc);
				
				/* Mail submitter */
				$htmlmsg = '<html><head><title></title></title></head><body>'.$this->_relToAbs($template->export_email_body).'</body></html>';
				$this->mailer->setBody($htmlmsg);
				$this->mailer->setSubject($template->export_email_subject);
				
				/* Add the attachemnt */
				$this->mailer->AddAttachment($exportfilename); 
				
				/* Send the mail */
				if (!$this->mailer->Send()) {
					$csvilog->AddStats('incorrect', JText::_('NO_MAIL_SEND').'<br />'.$this->mailer->error);
				}
				else {
					$csvilog->AddStats('information', JTEXT::_('MAIL_SEND'));
				}
				
				/* Clear the mail details */
				$this->mailer->ClearAddresses();
				
				/* Remove the temporary file */
				JFile::delete($exportfilename);
				break;
		}
	}
	
	/**
	* Convert links in a text from relative to absolute
	*
	* @access private
	* @return	string
	 */
	private function _relToAbs($text) {
		$base = JURI::root();
  		$text = preg_replace("/(href|src)=\"(?!http|ftp|https|mailto)([^\"]*)\"/", "$1=\"$base\$2\"", $text);

		return $text;
	}
	
	/**
	* Initialise the mailer object to start sending mails
	 */
	private function loadMailer() {
		$mainframe = Jfactory::getApplication();
		jimport('joomla.mail.helper');
		
		/* Start the mailer object */
		$this->mailer = JFactory::getMailer();
		$this->mailer->isHTML(true);
		$this->mailer->From = $mainframe->getCfg('mailfrom');
		$this->mailer->FromName = $mainframe->getCfg('sitename');
		$this->mailer->AddReplyTo(array($mainframe->getCfg('mailfrom'), $mainframe->getCfg('sitename')));
	}
	
	/**
	* Get the details for running the cron line
	 */
	public function getCronLine() {
		$cronline = '';
		
		/** Product Export* */
		/* Add the product categories */
		$productcategories = JRequest::getVar('productcategories', false);
		if ($productcategories &&  !empty($productcategories[0])) $cronline .= 'productcategories="'.implode('|', $productcategories).'|"';
		
		/* Filter by stocklevel start */
		$stocklevelstart = JRequest::getVar('stocklevelstart', false);
		if ($stocklevelstart) $cronline .= ' stocklevelstart="'.$stocklevelstart.'"';
		
		/* Filter by stocklevel end */
		$stocklevelend = JRequest::getVar('stocklevelend', false);
		if ($stocklevelend) $cronline .= ' stocklevelend="'.$stocklevelend.'"';
		
		/* Filter by stocklevel end */
		$productskufilter = JRequest::getVar('productskufilter', false);
		if ($productskufilter) $cronline .= ' productskufilter="'.$productskufilter.'"';
		
		/* Filter target currency */
		$targetcurrency = JRequest::getVar('targetcurrency', false);
		if ($targetcurrency) $cronline .= ' targetcurrency="'.$targetcurrency.'"';
		
		/* Filter op price quantity start */
		$pricequantitystartfrom = JRequest::getInt('pricequantitystartfrom', false);
		if ($pricequantitystartfrom) $cronline .= ' pricequantitystartfrom="'.$pricequantitystartfrom.'"';
		
		$pricequantitystartto = JRequest::getInt('pricequantitystartto', false);
		if ($pricequantitystartto) $cronline .= ' pricequantitystartto="'.$pricequantitystartto.'"';
		
		/* Filter op price quantity end */
		$pricequantityendfrom = JRequest::getInt('pricequantityendfrom', false);
		if ($pricequantityendfrom) $cronline .= ' pricequantityendfrom="'.$pricequantityendfrom.'"';
		
		$pricequantityendto = JRequest::getInt('pricequantityendto', false);
		if ($pricequantityendto) $cronline .= ' pricequantityendto="'.$pricequantityendto.'"';
		
		/** Order Export* */
		/* Filter by order number start */
		$ordernostart = JRequest::getVar('ordernostart', false);
		if ($ordernostart) $cronline .= ' ordernostart="'.$ordernostart.'"';
		
		/* Filter by order number end */
		$ordernoend = JRequest::getVar('ordernoend', false);
		if ($ordernoend) $cronline .= ' ordernoend="'.$ordernoend.'"';
		
		/* Filter by order date start */
		$orderdatestart = JRequest::getVar('orderdatestart', false);
		if ($orderdatestart) $cronline .= ' orderdatestart="'.$orderdatestart.'"';
		
		/* Filter by order date end */
		$orderdateend = JRequest::getVar('orderdateend', false);
		if ($orderdateend) $cronline .= ' orderdateend="'.$orderdateend.'"';
		
		/* Filter by order status */
		$orderstatus = JRequest::getVar('orderstatus', false);
		if ($orderstatus && !empty($orderstatus[0])) $cronline .= ' orderstatus="'.implode("|", $orderstatus).'|"';
		
		/* Filter by order price start */
		$orderpricestart = JRequest::getVar('orderpricestart', false);
		if ($orderpricestart) $cronline .= ' orderpricestart="'.$orderpricestart.'"';
		
		/* Filter by order price end */
		$orderpriceend = JRequest::getVar('orderpriceend', false);
		if ($orderpriceend) $cronline .= ' orderpriceend="'.$orderpriceend.'"';
		
		/* Filter by order user id */
		$orderuser = JRequest::getVar('orderuser', false);
		if ($orderuser && !empty($orderuser[0])) $cronline .= ' orderuser="'.implode("|", $orderuser).'|"';
		
		/* Filter by order product */
		$orderproduct = JRequest::getVar('orderproduct', false);
		if ($orderproduct && !empty($orderproduct[0])) $cronline .= ' orderproduct="'.implode("|", $orderproduct).'|"';
		
		/* Filter by address type */
		$order_address = JRequest::getVar('order_address', false);
		if ($order_address) $cronline .= ' order_address="'.$order_address.'"';
		
		/* Filter by order currency */
		$ordercurrency = JRequest::getVar('ordercurrency', false);
		if ($ordercurrency && !empty($ordercurrency[0])) $cronline .= ' ordercurrency="'.implode("|", $ordercurrency).'|"';
		
		/** User info export* */
		/* Filter by vendors */
		$vendors = JRequest::getVar('vendors', false);
		if ($vendors  && !empty($vendors[0])) $cronline .= ' vendors="'.implode("|", $vendors).'|"';
		
		/* Filter by permissions */
		$permissions = JRequest::getVar('permissions', false);
		if ($permissions  && !empty($permissions[0])) $cronline .= ' permissions="'.implode("|", $permissions).'|"';
		
		/* Filter by address type */
		$address = JRequest::getVar('userinfo_address', false);
		if ($address) $cronline .= ' vendors="'.$address.'"';
		
		/** Template fields export* */
		$exporttemplatefields = JRequest::getVar('exporttemplatefields');
		if ($exporttemplatefields && !empty($exporttemplatefields[0])) $cronline .= ' exporttemplatefields="'.implode("|", $exporttemplatefields).'|"';
		
		/** Template export* */
		$exporttemplate = JRequest::getVar('exporttemplate');
		if ($exporttemplate && !empty($exporttemplate[0])) $cronline .= ' exporttemplate="'.implode("|", $exporttemplate).'|"';
		
		/** All exports* */
		/* Filter by record start */
		$recordstart = JRequest::getVar('recordstart', false);
		if ($recordstart) $cronline .= ' recordstart="'.$recordstart.'"';
		
		/* Filter by record end */
		$recordend = JRequest::getVar('recordend', false);
		if ($recordend) $cronline .= ' recordend="'.$recordend.'"';
		
		/* Group by */
		$groupby = JRequest::getVar('groupby', false);
		if ($groupby) $cronline .= ' groupby="'.$groupby.'"';
		
		return $cronline;
	}
	
	/**
	* Perform replacement on a vale
	*
	* @author RolandD
	* @param int $id the id of the field to replace
	* @param string $value the text to replace
	* @return string the replaced text
	*/
	public function replaceValue($id, $value) {
		if (!$this->_replacements) {
			/* Load the replacements */
			$this->_replacementmodel = new CsvivirtuemartModelReplacement();
			$this->_replacements = $this->_replacementmodel->getExportReplacements($id);
		}
		
		/* Perform the regular replacement */
		if (count($this->_replacements['findtext']) > 0 && count($this->_replacements['replacetext']) > 0) {
			$fieldvalue = str_ireplace($this->_replacements['findtext'], $this->_replacements['replacetext'], $value);
		}
		else $fieldvalue = $value;
		
		/* Peform the regex replacement */
		if (count($this->_replacements['findregex']) > 0 && count($this->_replacements['replaceregex']) > 0) {
			$fieldvalue = preg_replace($this->_replacements['findregex'], $this->_replacements['replaceregex'], $fieldvalue);
		}
		
		/* All done return the value */
		return $fieldvalue;
	}
}
?>