<?php
/**
* Log model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: log.php 1138 2010-01-27 22:54:36Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Import Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelLog extends JModel {
	
	/** @var int holds the log ID */
	private $_id = null;
	/** @var object holds the pagination */
	private $_page = null;
	/** @var int holds the total number of items in database */
	private $_limittotal = null;
	/** @var int holds the number of items to display */
	private $_limit = null;
	/** @var int holds the offset where to start */
	private $_limitstart = null;
	
	/**
	* Set the log ID
	 */
	public function setId($id) {
		 $this->_id = $id;
	}
	/**
	* Load the log entries
	*
	 */
	public function getLogEntries() {
		$db = JFactory::getDBO();
		$q = "SELECT * 
			FROM #__csvivirtuemart_logs
			ORDER BY logstamp DESC";
		$db->setQuery($q, $this->_page->limitstart, $this->_page->limit);
		$logs =  $db->loadObjectList();
		if ($db->getErrorNum() == 0) {
			return $logs;
		}
		else {
			JError::raiseWarning(0, JText::_('Cannot load logs'));
			return false;
		}
	}
	
	/**
	* Load total of records
	 */
	public function getTotal() {
		$db = JFactory::getDBO();
		$q = "SELECT COUNT(id) AS total FROM #__csvivirtuemart_logs";
		$db->setQuery($q);
		$this->_limittotal = $db->loadResult();
		
		if ($db->getErrorNum() > 0) {
			JError::raiseWarning(0, JText::_('Cannot get total logs').' :: '.$db->getErrormsg());
			$this->_limittotal = 0;
		}
	}
	
	/**
	* Load the pagination
	 */
	public function getPagination() {
      global $mainframe;
		/* Load totals */
		$this->getTotal();
		
      /* Lets load the pagination if it doesn't already exist */
      if (empty($this->_page)) {
         jimport('joomla.html.pagination');
         $this->_limit      = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
         $this->_limitstart = $mainframe->getUserStateFromRequest( 'com_csvivirtuemart.limitstart', 'limitstart', 0, 'int' );
         $this->_page = new JPagination($this->_limittotal, $this->_limitstart, $this->_limit);
      }
      return $this->_page;
	}
	
	/**
	* Store the log results after import/export
	 */
	public function getStoreLogResults() {
		$db = JFactory::getDBO();
		$csvilog = JRequest::getVar('csvilog');
		$template = JRequest::getVar('template', false);
		$logresult = $csvilog->GetStats();
		$details = array();
		$logcount = array();
		if ($template && stristr($template->template_type, 'import')) {
			/* Store the logcount for insert into log table */
			$logcount['import'] = JRequest::getInt('currentline');
		}
		else {
			$logcount = JRequest::getVar('logcount');
		}
		
		/* Get user ID */
		$my = JFactory::getUser();
		$details['userid'] = $my->id;
		/* Create GMT timestamp */
		jimport('joomla.utilities.date');
		$jnow = new JDate(time());
		$details['logstamp'] = $jnow->toMySQL();
		/* Set action if it is import or export */
		$details['action'] = $logresult['action'];
		/* Type of action */
		$details['action_type'] = $logresult['action_type'];
		/* Name of template used */
		$details['template_name'] = $logresult['action_template'];
		/* Get the number of records */
		$details['records'] = $logcount[$logresult['action']];
		/* Get the import ID */
		$details['import_id'] = $csvilog->getImportId();
		/* Get the import filename */
		$details['file_name'] = $csvilog->getFilename();
		
		/* Get the database connector */
		$rowlog = $this->getTable('csvi_logs');
		/* Bind the data */
		if (!$rowlog->bind($details)) {
			JError::raiseWarning(0, JText::_('CANNOT_BIND_LOG_DATA'));
		}
		/* Check the data */
		if (!$rowlog->check()) {
			JError::raiseWarning(0, JText::_('CANNOT_CHECK_LOG_DATA'));
		}
		
		/* Store the data */
		if (!$rowlog->store()) {
			JError::raiseWarning(0, JText::_('CANNOT_STORE_LOG_DATA'));
		}
		
		/* Store the log details */
		$q = 'INSERT INTO `#__csvivirtuemart_log_details` ( `id`,`log_id`,`line`,`description`,`result`,`status` ) VALUES ';
		foreach ($logresult as $linenr => $result) {
			if (is_int($linenr)) {
				foreach ($result['status'] as $status => $stat) {
					$q .= "(0, ".$rowlog->id.", ".$linenr.", ".$db->Quote(trim($stat['message'])).", '".$stat['result']."', '".$status."'),\n";
				}
			}
		}
		$q = substr(trim($q), 0, -1).';';
		$db->setQuery($q);
		$db->query();
		$rowlog->reset();
	}
	
	/**
	* Delete a log entry
	 */
	public function getDelete() {
		$mainframe = Jfactory::getApplication('administrator');
		jimport('joomla.filesystem.file');
		$db = JFactory::getDBO();
		$cids = JRequest::getVar('cid');
		$file_not_found = 0;
		$file_deleted = 0;
		$file_not_deleted = 0;
		$log_del = 0;
		$log_del_error = 0;
		$log_detail_del = 0;
		$log_detail_del_error = 0;
		
		/* Make it an array */
		if (!is_array($cids)) (array)$cids;
		
		$rowlog = $this->getTable('csvi_logs');
		$folder = JPATH_ROOT.DS.'administrator'.DS.'cache'.DS.'com_csvivirtuemart'.DS.'debug'.DS;
		foreach ($cids as $key => $import_id) {
			$filename = $folder.'com_csvivirtuemart.log.'.$import_id.'.php';
			if (JFile::exists($filename)){
				if (JFile::delete($filename)) {
					$file_deleted++;
				}
				else $file_not_deleted++;
			}
			else $file_not_found++;
			
			/* Delete the log entry */
			if (empty($import_id)) $q = "SELECT id FROM #__csvivirtuemart_logs WHERE (import_id = '' OR import_id IS NULL)"; 
			else $q = "SELECT id FROM #__csvivirtuemart_logs WHERE import_id = ".$import_id; 
            
			$db->setQuery($q);
			$ids = $db->loadResultArray();
			foreach ($ids as $idkey => $id) {
				if (!$rowlog->delete($id)) $log_del_error++;
				else {
					$log_del++;
				}
				
				/* Delete the log details */
				$q = "DELETE FROM #__csvivirtuemart_log_details
					WHERE log_id = ".$id;
				$db->setQuery($q);
				if (!$db->query()) $log_detail_del_error++;
				else $log_detail_del++;
			}
		}
		
		/* Set the results */
		if ($file_not_found > 0) {
			if ($file_not_found == 1) $mainframe->enqueueMessage(JText::_('DELETE_LOG_FILE_NOT_FOUND'));
			else $mainframe->enqueueMessage(str_replace('{X}', $file_not_found, JText::_('DELETE_LOGS_FILE_NOT_FOUND')));
		}
		if ($file_deleted > 0) {
			if ($file_deleted == 1) $mainframe->enqueueMessage(JText::_('DELETE_LOG_FILE'));
			else $mainframe->enqueueMessage(str_replace('{X}', $file_deleted, JText::_('DELETE_LOGS_FILE')));
		}
		if ($file_not_deleted > 0) {
			if ($file_not_deleted == 1) $mainframe->enqueueMessage(JText::_('CANNOT_DELETE_LOG_FILE'), 'error');
			else $mainframe->enqueueMessage(str_replace('{X}', $file_not_deleted, JText::_('CANNOT_DELETE_LOGS_FILE')), 'error');
		}
		if ($log_del > 0) {
			if ($log_del == 1) $mainframe->enqueueMessage(JText::_('DELETE_LOG_DATA'));
			else $mainframe->enqueueMessage(str_replace('{X}', $log_del, JText::_('DELETE_LOGS_DATA')));
		}
		if ($log_del_error > 0) {
			if ($log_del == 1) $mainframe->enqueueMessage(JText::_('CANNOT_DELETE_LOG_DATA'), 'error');
			else $mainframe->enqueueMessage(str_replace('{X}', $log_del, JText::_('CANNOT_DELETE_LOGS_DATA')), 'error');
		}
		if ($log_detail_del > 0) {
			if ($log_del == 1) $mainframe->enqueueMessage(JText::_('DELETE_LOG_DETAILS_DATA'));
			else $mainframe->enqueueMessage(str_replace('{X}', $log_detail_del, JText::_('DELETE_LOGS_DETAILS_DATA')));
		}
		if ($log_detail_del_error > 0) {
			if ($log_del == 1) $mainframe->enqueueMessage(JText::_('CANNOT_DELETE_LOG_DETAILS_DATA'), 'error');
			else $mainframe->enqueueMessage(str_replace('{X}', $log_detail_del_error, JText::_('CANNOT_DELETE_LOGS_DETAILS_DATA')), 'error');
		}
	}
	
	/**
	* Delete a log entry
	 */
	public function getDeleteAll() {
		$mainframe = JFactory::getApplication('site');
		$db = JFactory::getDBO();
		$q = "TRUNCATE ".$db->nameQuote('#__csvivirtuemart_logs');
		$db->setQuery($q);
		if ($db->query()) $mainframe->enqueueMessage(JText::_('DELETE_LOG_DATA_ALL_OK'));
		else $mainframe->enqueueMessage(JText::_('DELETE_LOG_DATA_ALL_NOK'));
		
		$q = "TRUNCATE ".$db->nameQuote('#__csvivirtuemart_log_details');
		$db->setQuery($q);
		if ($db->query()) $mainframe->enqueueMessage(JText::_('DELETE_LOG_DATA_DETAILS_ALL_OK'));
		else $mainframe->enqueueMessage(JText::_('DELETE_LOG_DATA_DETAILS_ALL_NOK'));
	}
	
	/**
	* Load the statistics
	*/
	public function getStats() {
		$db = JFactory::getDBO();
		$import_id = JRequest::getInt('import_id', false);
		
		if (!$import_id) {
			/* Try to get it from the cid */
			$cids = JRequest::getVar('cid');
			if (array_key_exists('0', $cids)) $import_id = $cids[0];
		}
		
		$details = array();
		if ($import_id) {
			jimport('joomla.filesystem.file');
			
			/* Get the total number of records */
			$q = "SELECT SUM(records) AS total_records 
				FROM #__csvivirtuemart_logs 
				WHERE import_id = ".$import_id;
			$db->setQuery($q);
			$details['total_records'] = $db->loadResult();
			
			/* Get the general details */
			$q = "SELECT MIN(id) AS min_id, MAX(id)+1 AS max_id, file_name, action_type
				FROM #__csvivirtuemart_logs WHERE import_id = ".$import_id;
			$db->setQuery($q);
			$min_max = $db->loadObject();
			
			/* Set the filename */
			$details['file_name'] = $min_max->file_name;
			
			/* Set the action type */
			$details['action_type'] = $min_max->action_type;
			
			/* Get some status results */
			$q = "SELECT COUNT(status) AS total_result, result, status
				FROM #__csvivirtuemart_log_details WHERE log_id BETWEEN ".$min_max->min_id." AND ".$min_max->max_id."
				GROUP BY status";
			$db->setQuery($q);
			$details['result'] = $db->loadObjectList('status');
			
			/* Check if there is a debug log file */
			$logfile = JPATH_ROOT.DS.'administrator'.DS.'cache'.DS.'com_csvivirtuemart'.DS.'debug'.DS.'com_csvivirtuemart.log.'.$import_id.'.php';
			if (JFile::exists($logfile)) {
				$details['debug'] = JHTML::_('link', JRoute::_('index.php?option=com_csvivirtuemart&controller=log&task=downloaddebug&import_id='.$import_id), JText::_('DEBUG_LOG'));
			}
			else $details['debug'] = JText::_('NO_DEBUG_LOG_FOUND');
		}
		return $details;
	}
	
	/**
	* Load the statistics
	*/
	public function getStatsMessage() {
		$db = JFactory::getDBO();
		$import_id = JRequest::getInt('import_id', false);
		if (!$import_id) {
			/* Try to get it from the cid */
			$cids = JRequest::getVar('cid');
			if (array_key_exists('0', $cids)) $import_id = $cids[0];
		}
		$details = array();
		if ($import_id) {
			$q = "SELECT line, description, status, log_id, result
				FROM #__csvivirtuemart_log_details 
				WHERE log_id IN (SELECT id FROM #__csvivirtuemart_logs WHERE import_id = ".$import_id.")
				ORDER BY line";
			$db->setQuery($q);
			$details =  $db->loadObjectList();
		}
		return $details;
	}
	
	/**
	* Download a debug report
	*/
	public function downloadDebug() {
		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.archive');
		$import_id = JRequest::getInt('import_id');
		$filepath = JPATH_ROOT.DS.'administrator'.DS.'cache'.DS.'com_csvivirtuemart'.DS.'debug'.DS;
		$filename = 'com_csvivirtuemart.log.'.$import_id.'.';
		
		$zip = JArchive::getAdapter('zip');
		$files = array();
		$files[] = array('name' => $filename.'php', 'time' => filemtime($filepath.$filename.'php'), 'data' => JFile::read($filepath.$filename.'php'));
        $zip->create($filepath.$filename.'zip', $files);
		
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
		header('Content-Description: File Transfer');
		header('Content-Type: ' . $mime_type);
		header('Content-Transfer-Encoding: binary');
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Length: ' . filesize($filepath.$filename.'zip'));

		if ($UserBrowser == 'IE') {
			header('Content-Disposition: inline; filename="'.$filename.'zip"');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} else {
			header('Content-Disposition: attachment; filename="'.$filename.'zip"');
			header('Pragma: no-cache');
		}
		/* Send the file */
		readfile($filepath.$filename.'zip');
		JFile::delete($filepath.$filename.'zip');
		
		/* Close the transmission */
		exit();
	}
}
?>