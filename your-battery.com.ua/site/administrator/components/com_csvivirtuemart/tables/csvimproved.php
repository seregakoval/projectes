<?php
/**
* Joomla Components table
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvimproved.php 1117 2010-01-01 21:39:52Z Roland $
 */

/* No direct access */
defined('_JEXEC') or die('Restricted access');

/**
* @package CSVIVirtueMart
 */
class TableCsvimproved extends JTable {
	
	function bind($array, $ignore = '') {
        if (key_exists( 'params', $array ) && is_array( $array['params'] )) {
                $registry = new JRegistry();
                $registry->loadArray($array['params']);
                $array['params'] = $registry->toString();
        }
        return parent::bind($array, $ignore);
    }
}
?>