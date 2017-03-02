<?php
/**
* Google Base XML class
*
* @package CSVIVirtueMart
* @subpackage Export
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvi_class_xml_froogle.php 1117 2010-01-01 21:39:52Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Froogle XML Export Class
*
* @package CSVIVirtueMart
* @subpackage Export
 */
class CsviXmlFroogle {
	
	/** @var string contains the data to export */
	var $contents = "";
	/** @var string contains the XML node to export */
	var $node = "";
	
	/**
	* Creates the XML header
	*
	* @see $contents
	* @return string XML header
	 */
	function HeaderText() {
		$this->contents = '<?xml version="1.0" encoding="UTF-8"?>'.chr(10);
		$this->contents .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0" ';
		/* Google Base Custom Namespace */
		$this->contents .= 'xmlns:c="http://base.google.com/cns/1.0">'.chr(10);
		$this->contents .= '<channel>'.chr(10);
		/* Get the XML channel header */
		$settings = new CsvivirtuemartModelSettings();
		$paramsdata = $settings->getSettings();
		$paramsdefs = JPATH_COMPONENT_ADMINISTRATOR.DS.'views'.DS.'settings'.'config.xml';
		$params = new JParameter( $paramsdata, $paramsdefs );
		$this->contents .= '<title>'.$params->get('gb_title').'</title>'.chr(10);
		$this->contents .= '<link>'.$params->get('gb_link').'</link>'.chr(10);
		$this->contents .= '<description>'.$params->get('gb_description').'</description>'.chr(10);
		return $this->contents;
	}
	
	/**
	* Creates the XML footer
	*
	* @see $contents
	* @return string XML header
	 */
	function FooterText() {
		$this->contents = '</channel>'.chr(10);
		$this->contents .= '</rss>'.chr(10);
		return $this->contents;
	}
	
	/**
	* Opens an XML item node
	*
	* @see $contents
	* @return string XML node data
	 */
	function NodeStart() {
		$this->contents = '<item>'.chr(10); 
		return $this->contents;
	}
	
	/**
	* Closes an XML item node
	*
	* @see $contents
	* @return string XML node data
	 */
	function NodeEnd() {
		$this->contents = '</item>'.chr(10); 
		return $this->contents;
	}
	
	/**
	* Adds an XML element
	*
	* @see $node
	* @return string XML element
	 */
	function Element($column_header, $cdata=false) {
		if (stristr($column_header, 'c:')) {
			$this->node = '<'.$column_header.' type="string">';
		}
		else $this->node = '<'.$column_header.'>';
		if ($cdata) $this->node .= '<![CDATA[';
		$this->node .= $this->contents;
		if ($cdata) $this->node .= ']]>';
		$this->node .= '</'.$column_header.'>';
		$this->node .= "\n";
		return $this->node;
	}
	
	/**
	* Handles all content and modifies special cases
	*
	* @see $contents
	* @return string formatted XML element
	 */
	function ContentText($content, $column_header, $fieldname, $cdata=false) {
		switch ($fieldname) {
			case 'custom':
				switch($column_header) {
					case 'g:shipping':
						list($country, $service, $price) = explode(":", $content);
						$this->contents = '
						<g:country>'.$country.'</g:country>
						<g:service>'.$service.'</g:service>
						<g:price>'.$price.'</g:price>
						';
					break;
					case 'g:tech_spec_link':
						$cdate = true;
					default:
						$this->contents = $content;
						break;
				}
				break;
			case 'category_path':
				$paths = explode("|", $content);
				$content = '';
				foreach ($paths as $id => $path) {
					$this->contents = str_replace('/', '>', $path);
					$content .= $this->Element($column_header, $cdata);
				}
				return $content;
				break;
			case 'manufacturer_name':
			case 'product_url':
				$cdata = true;
			default:
				$this->contents = $content;
				break;
		}
		return $this->Element($column_header, $cdata);
	}
}
?>
