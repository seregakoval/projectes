<?php
/**
* Main file processor class
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_class_file.php 1129 2010-01-14 10:33:40Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
 
/** 
* CsviFile class 
* 
* The CsviFile class handles all file operations regarding reading CSV and XLS
* files. XLS reading is supported through the ExcelReader class.
*
* @package CSVIVirtueMart
* @see Spreadsheet_Excel_Reader::read()
 */
class CsviFile {
	
	/** @var array Contains allowed extensions for uploaded files */
	var $suffixes = array();
	
	/** @var array Contains allowed mimetypes for uploaded files */
	var $mimetypes = array();
	
	/** @var array Contains allowed archivetypes for uploaded files */
	var $archives = array();
	
	/** @var string Contains the name of the uploaded file */
	var $filename = '';
	
	/** @var string Contains the extension of the uploaded file */
	var $extension = '';
	
	/** @var bool Contains the value whether or not the file uses
	* an extension that is allowed.
	*
	* @see $suffixes
	*/
	var $valid_extension = false;
	
	/** @var bool Filepointer used when opening files */
	var $fp = false;
	
	/** @var integer Internal line pointer */
	var $linepointer = 2;
	
	/** @var array Contains the data that is read from file */
	var $data = null;
	
	/** @var string Contains the field delimiter */
	private $_field_delimiter = null;
	
	/** @var string Contains the text enclosure */
	private $_text_enclosure = null;
	
	/** @var string Path for unpacking files **/
	private $_unpackpath = null;
	
	/** @var bool Sets to true if a file has been uploaded **/
	private $_uploaded = false;
	
	/** @var bool Sets to true if a file has been closed **/
	private $_closed = false;
	
	/**
	* Controls the reading of a file
	*
	* Determines on extension what file reading method to use.
	*/
	public function __construct() {
		/* Load the necessary libraries */
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.archive');
		$this->_unpackpath = JPATH_CACHE.DS.'com_csvivirtuemart';
		
		/* Load some basic settings */
		$this->FileSettings();
	}
	
	/**
	* Set the settings to work with
	*
	* @see $suffixes
	* @see $mimetypes
	* @see $data
	*/
	function FileSettings() {
		$this->suffixes = array('txt','csv','xls','xml','ods');
		$this->mimetypes = array('text/html',
							'text/plain',
							'text/csv',
							'application/octet-stream',
							'application/x-octet-stream',
							'application/vnd.ms-excel',
							'application/excel',
							'application/ms-excel',
							'application/x-excel',
							'application/x-msexcel',
							'application/force-download',
							'text/comma-separated-values',
							'text/x-csv',
							'text/x-comma-separated-values',
							'application/vnd.oasis.opendocument.spreadsheet');
		$this->archives = array('zip', 'tgz');
		$this->data->sheets[0] = array();
	}
	
	/**
	* Open the uploaded file
	*
	* @todo Check for memory consumption xls
	* @todo Add failure handling moving ODS file
	 */
	function processFile() {
		$csvilog = JRequest::getVar('csvilog');
		switch($this->extension) {
			case 'csv':
				/* Open the csv file */
				$this->fp = fopen($this->filename,"r");
				/* Load the delimiters */
				$this->findDelimiters();
				break;
			case 'xls':
				$this->fp = true;
				$this->linepointer = 2;
				$this->data = new Spreadsheet_Excel_Reader($this->filename, false);
				break;
			case 'xml':
				$this->fp = true;
				$this->linepointer = 0;
                $this->data = simplexml_load_file($this->filename);
				if (!$this->data){
					$csvilog->AddStats('incorrect', JText::_('ERROR_READING_XML_FILE'));
					return false;
				}
				$this->data->items = count($this->data->item);
				break;
			case 'ods':
				$this->fp = true;
				$this->linepointer = 1;
				$this->data = new ODSParser();
				/* First we need to unpack the zipfile */
				$unpackfile = $this->_unpackpath.DS.JRequest::getVar('user_filename').'.zip';
				$importfile = $this->_unpackpath.DS.'content.xml';
				
				/* Check the unpack folder */
				JFolder::create($this->_unpackpath);
				
				/* Delete the destination file if it already exists */
				if (JFile::exists($unpackfile)) JFile::delete($unpackfile);
				if (JFile::exists($importfile)) JFile::delete($importfile);
				
				/* Now copy the file to the folder */
				JFile::copy($this->filename, $unpackfile);
				
				/* Clean the csvi folder */
				if (!JArchive::extract($unpackfile, $this->_unpackpath)) {
					$csvilog->AddStats('incorrect', JText::_('Cannot unpack ODS file'));
					return false;
				}
				/* File is always called content.xml */
				else $this->filename = $importfile;
				$this->data->read($this->filename);
				break;
		}
	}
	
	/**
	* Validate the file
	*
	* Validate the file is of the supported type
	* Types supported are csv, txt, xls
	*
	* @return bool returns true if all fine else false
	 */
	function validateFile() {
		$csvilog = JRequest::getVar('csvilog');
		
		if (JRequest::getInt('filepos', 0) >= 0) {
			$csv_file = JRequest::getVar('local_csv_file', false);
			if (!$csv_file) {
				$csv_file = urldecode(JRequest::getVar('csv_file'));
				JRequest::setVar('local_csv_file', $csv_file);
			}
			$this->folder = dirname($csv_file);
			JRequest::setVar('csv_file', $csv_file);
		}
		
		switch (JRequest::getVar('selectfile')) {
			/* No file given */
			case 0:
				$csvilog->AddStats('incorrect', 'No file provided.');
				return false;
				break;
			/* Uploaded file */
			case 1:
				$upload = JRequest::getVar('file', '', 'files');
				/* Check if the file upload has an error */
				if ($upload['error'] == 0) {
					if (is_uploaded_file($upload['tmp_name'])) {
						/* Get some basic info */
						$folder = $this->_unpackpath.DS.time();
						$upload_parts = pathinfo($upload['name']);
						
						/* Create the temp folder */
						if (JFolder::create($folder)) {
							$this->folder = $folder;
							/* Move the uploaded file to its temp location */
							if (JFile::upload($upload['tmp_name'], $folder.DS.$upload['name'])) {
								$this->_uploaded = true;
								/* Let's see if the uploaded file is an archive */
								if (in_array($upload_parts['extension'], $this->archives)) {
									/* It is an archive, unpack first */
									if (JArchive::extract($folder.DS.$upload['name'], $folder)) {
										/* File is unpacked, let's get the filename */
										$foundfiles = scandir($folder);
										foreach ($foundfiles as $ffkey => $filename) {
											$ff_parts = pathinfo($filename);
											if (in_array(strtolower($ff_parts['extension']), $this->suffixes)) {
												JRequest::setVar('csv_file', $folder.DS.$filename);
												JRequest::setVar('upload_file_error', false);
												$this->extension = strtolower($ff_parts["extension"]);
												end($foundfiles);
											}
											else $found = false;
										}
										if (!$found) JRequest::setVar('upload_file_error', true);
									}
									else {
										$csvilog->AddStats('incorrect', JText::_('CANNOT_UNPACK_UPLOADED_FILE'));
										return false;
									}
								}
								/* Just a regular file */
								else {
									JRequest::setVar('csv_file', $folder.DS.$upload['name']);
									$this->extension = strtolower($upload_parts['extension']);
								}
							}
						}
						else {
							$csvilog->AddStats('incorrect', JText::_('CANNOT_CREATE_UNPACK_FOLDER'));
							return false;
						}
					}
					/* Error warning cannot save uploaded file */
					else {
						$csvilog->AddStats('incorrect', JText::_('No uploaded file provided'));
						return false;
					}
					
					/* Make sure txt files are not ignored */
					if ($this->extension == 'txt') $this->extension = 'csv';
				}
				else {
					/* There was a problem uploading the file */
					switch($upload['error']) {
						case '1':
							$csvilog->AddStats('incorrect', JText::_('The uploaded file exceeds the maximum uploaded file size'));
							break;
						case '2':
							$csvilog->AddStats('incorrect', JText::_('The uploaded file exceeds the maximum uploaded file size'));
							break;
						case '3':
							$csvilog->AddStats('incorrect', JText::_('The uploaded file was only partially uploaded'));
							break;
						case '4':
							$csvilog->AddStats('incorrect', JText::_('No file was uploaded'));
							break;
						case '6':
							$csvilog->AddStats('incorrect', JText::_('Missing a temporary folder'));
							break;
						case '7':
							$csvilog->AddStats('incorrect', JText::_('Failed to write file to disk'));
							break;
						case '8':
							$csvilog->AddStats('incorrect', JText::_('File upload stopped by extension'));
							break;
						default:
							$csvilog->AddStats('incorrect', JText::_('There was a problem uploading the file'));
							break;
					}
					return false;
				}
				break;
			/* Local file */
			case 2:
				JRequest::setVar('csv_file', str_replace(array('\\','/'), array(DS,DS), JRequest::getVar('local_csv_file')));
				if (!JFile::exists(JRequest::getVar('csv_file'))) {
					$csvilog->AddMessage('debug', '[VALIDATEFILE] '.JText::_('LOCAL_FILE_DOESNT_EXIST').' '.JRequest::getVar('local_csv_file'));
					$csvilog->AddStats('incorrect', JText::_('LOCAL_FILE_DOESNT_EXIST').' '.JRequest::getVar('local_csv_file'));
					return false;
				}
				else JRequest::setVar('upload_file_error', false);
				$fileinfo = pathinfo(JRequest::getVar('csv_file'));
				if (isset($fileinfo["extension"])) {
					$this->extension = strtolower($fileinfo["extension"]);
					if ($this->extension == 'txt') $this->extension = 'csv';
				}
				break;
		}
		/* Set the filename */
		if (JFile::exists(JRequest::getVar('csv_file'))) {
			$this->filename = JRequest::getVar('csv_file');
			
			/* Store the users filename for display purposes */
			$csvilog->setFilename(basename($this->filename));
		}
		else {
			$csvilog->AddMessage('debug', JText::_('LOCAL_FILE_DOESNT_EXIST').' '.JRequest::getVar('csv_file'));
			return false;
		}
		if (in_array($this->extension, $this->suffixes)) $this->valid_extension = true;
		else {
			/* Test the mime type */
			if (!in_array($this->extension, $this->mimetypes) ) {
				$csvilog->AddStats('incorrect', JText::_('MIME_TYPE_NOT_ACCEPTED').' '.$this->extension);
				return false;
			}
		}
		/* Debug message to know what filetype the user is uploading */
		$csvilog->AddMessage('debug', 'Importing filetype: '.$this->extension);
		
		/* All is fine */
		return true;
	}
	
	/**
	* Read the next line
	*
	* Reads the next line of the uploaded file
	* In case of csv, it reads the next line from the file
	* In case of xls, it returns the next entry in the array because the whole 
	* file is already read
	*
	* @return array with the line of data read
	 */
	function ReadNextLine() {
		$newdata = array();
		switch ($this->extension) {
			case 'csv':
				/* Check if the file is still open */
				if ($this->_closed) return;
					
				/* Make sure we have delimiters */
				if (is_null($this->_field_delimiter)) return false;
				
				/* Ignore empty records */
				$csvdata = array(0=>'');
                while (is_array($csvdata) && count($csvdata)==1 && $csvdata[0]=='') {
                    if (!is_null($this->_text_enclosure)) $csvdata = fgetcsv($this->fp, 0, $this->_field_delimiter, $this->_text_enclosure); 
                    else $csvdata = fgetcsv($this->fp, 0, $this->_field_delimiter); 
                }
				if ($csvdata) {
					/* Do BOM check */
					if (JRequest::getVar('currentline') == 1) {
						/* Remove text delimiters as they are not recognized by fgetcsv */
						$csvdata[0] = str_replace($this->_text_enclosure, "", $this->CheckBom($csvdata[0]));
					}
					foreach ($csvdata as $key => $value) { 
                        $newdata[$key+1] = $value; 
                    } 
                    return $newdata;
				}
				else return false;
				
				break;
			case 'xls':
				if ($this->data->sheets[0]['numRows'] >= $this->linepointer) {
					/* Make sure we include the empty fields */
					for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
					   if (!isset($this->data->sheets[0]['cells'][$this->linepointer][$i])) $this->data->sheets[0]['cells'][$this->linepointer][$i] = '';
					}
					$newdata = $this->data->sheets[0]['cells'][$this->linepointer];
					$this->linepointer++;
					return $newdata;
				}
				else return false;
				break;
			case 'xml':
				if ($this->data->items > $this->linepointer) {
					$newdata = $this->toArray($this->data->item[$this->linepointer], false);
					$this->linepointer++;
					return $newdata;
				}
				else return false;
				break;
			case 'ods':
				if ($this->data->rows > $this->linepointer) {
					$newdata = $this->data->_data[$this->linepointer];
					$this->linepointer++;
					return $newdata;
				}
				else return false;
				break;
		}
	}
	
	/**
	* Close the file
	*
	* Closes the csv file pointer
	*
	* @see processFile()
	* @todo Enable folder deletion
	*/
	function CloseFile($removefolder=true) {
		switch ($this->extension) {
			case 'csv':
				/* Close csv file */
				fclose($this->fp);
				$this->_closed = true;
				break;
		}
		/* Delete the uploaded folder */
		if ($removefolder && !JRequest::getBool('cron', false)) {
			$folder = dirname($this->filename);
			$pos = strpos($folder, JPATH_CACHE.DS.'com_csvivirtuemart');
			if ($pos !== false) if (JFolder::exists($folder)) JFolder::delete($folder);
		}
	}
	
	
	/**
	* Checks if the uploaded file has a BOM
	*
	* If the uploaded file has a BOM, remove it since it only causes
	* problems on import.
	*
	* @see ReadNextLine()
	* @param &$data The string to check for a BOM
	* @return string return the cleaned string
	 */
	function CheckBom(&$data) {
		/* Check the first three characters */
		if (strlen($data) > 3) {
			if (ord($data{0}) == 239 && ord($data{1}) == 187 && ord($data{2}) == 191) {
				return substr($data, 3, strlen($data));
			}
			else return $data;
		}
		else return $data;
	}
	
	/**
	* Convert an XML node into an array
	*
	* @param $data object XML node to convert
	* @return array XML node as an array
	 */
	function toArray($data, $firstline) {
		$newdata = array();
		$counter = 1;
		foreach($data as $name => $value) {
			if ($firstline) $newdata[$counter] = $name;
			else $newdata[$counter] = $value;
			$counter++;
		}
		return $newdata;
	}
	
	/**
	* Find the delimiters used
	 */
	private function findDelimiters() {
		$csvilog = JRequest::getVar('csvilog');
		$template = JRequest::getVar('template');
		if (!$template->auto_detect_delimiters) {
			/* Set the field delimiter */
			if (strtolower($template->field_delimiter) == 't') $this->_field_delimiter = "\t";
			else $this->_field_delimiter = $template->field_delimiter;
			
			/* Set the text enclosure */
			$this->_text_enclosure = ($template->text_enclosure) ? $template->text_enclosure : null;
		}
		else {
			/* Read the first line */
			rewind($this->fp);
			$line = fgets($this->fp);
			
			/* 1. Is the user using text enclosures */
			$first_char = substr($line, 0, 1);
			$pattern = '/[a-zA-Z0-9_]/';
			$matches = array();
			preg_match($pattern, $first_char, $matches);
			if (count($matches) == 0) {
				/* User is using text delimiter */
				$this->_text_enclosure = $first_char;
				$csvilog->addMessage('debug', JText::_('FOUND_TEXT_ENCLOSURE').' '.$first_char);
				
				/* 2. What field delimiter is being used */
				$match_next_char = strpos($line, $this->_text_enclosure, 1);
				$second_char = substr($line, $match_next_char+1, 1);
				if ($first_char == $second_char) {
					JRequest::setVar('error_found', true);
					JError::raiseWarning(0, JText::_('CANNOT_FIND_TEXT_DELIMITER'));
					return false;
				}
				else {
					$this->_field_delimiter = $second_char;
				}
			}
			else {
				$totalchars = strlen($line);
				/* 2. What field delimiter is being used */
				for ($i = 0;$i <= $totalchars; $i++) {
					$current_char = substr($line, $i, 1);
					preg_match($pattern, $current_char, $matches);
					if (count($matches) == 0) {
						$this->_field_delimiter = $current_char;
						$i = $totalchars;
					}
				}
			}
			$csvilog->addMessage('debug', JText::_('FOUND_FIELD_DELIMITER').' '.$this->_field_delimiter);
			rewind($this->fp);
		}
		return true;
	}
	
	/**
	* Get the current position in the CSV file
	*/
	public function getFilePos() {
		switch ($this->extension) {
			case 'csv':
				return ftell($this->fp);
				break;
			case 'xls':
			case 'xml':
			case 'ods':
				return $this->linepointer;
				break;
		}
	}
	
	/**
	* Set the current position in the CSV file
	*/
	public function setFilePos($pos) {
		switch ($this->extension) {
			case 'csv':
				return fseek($this->fp, $pos);
				break;
			case 'xls':
			case 'xml':
			case 'ods':
				$this->linepointer = $pos;
				return $this->linepointer;
				break;
		}
		
	}
	
	/**
	* Get the size of the CSV file
	*/
	public function getFileSize() {
		switch ($this->extension) {
			case 'csv':
				return filesize($this->filename);
				break;
			case 'xls':
				return $this->data->sheets[0]['numRows'];
				break;
			case 'xml':
				return $this->data->items;
				break;
			case 'ods':
				return $this->data->rows;
				break;
		}
	}
	
	/**
	* Load the column headers from a file
	*/
	public function loadColumnHeaders() {
		switch ($this->extension) {
			case 'csv':
				/* Column headers are always the first line of the file */
				/* 1. Store current position */
				$curpos = $this->getFilePos();
				/* 2. Go to the beginning of the file */
				$this->setFilePos(0);
				/* 3. Read the line */
				JRequest::setVar('columnheaders', $this->ReadNextLine());
				/* 4. Set the position back */
				if ($curpos > 0) $this->setFilePos($curpos);
				return true;
				break;
			case 'xls':
				/* Make sure we include the empty fields */
				for ($i=1;$i<=$this->data->sheets[0]['numCols'];$i++) {
					if (!isset($this->data->sheets[0]['cells'][1])) $this->data->sheets[0]['cells'][1][$i] = '';
				}
				JRequest::setVar('columnheaders', $this->data->sheets[0]['cells'][1]);
				break;
			case 'xml':
				/* XML has no column headers */
				JRequest::setVar('columnheaders', $this->toArray($this->data->item[0], true));
				return true;
				break;
			case 'ods':
				JRequest::setVar('columnheaders', $this->data->_data[1]);
				break;
		}
	}
	
	/**
	* Advances the file pointer 1 forward
	*/
	public function next() {
		$discard = $this->ReadNextLine();
		return;
	}
}
?>