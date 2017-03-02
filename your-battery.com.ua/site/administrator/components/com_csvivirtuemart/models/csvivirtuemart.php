<?php
/**
* Control panel model
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: csvivirtuemart.php 1119 2010-01-04 23:31:29Z Roland $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.model' );

/**
* Available fields Model
*
* @package CSVIVirtueMart
 */
class CsvivirtuemartModelCsvivirtuemart extends JModel {
	
	/**
	* Get the buttons for the control panel
	 */
	public function getButtons() {
		/* Get the Cpanel images */
		$cpanel_images = new stdClass();
		$cpanel_images->templates = $this->CpanelButton('csvivirtuemart_template_48.png', 'index2.php?option=com_csvivirtuemart&task=templates&controller=templates', 'TEMPLATES');
		$cpanel_images->import = $this->CpanelButton('csvivirtuemart_import_48.png', 'index2.php?option=com_csvivirtuemart&task=import&controller=import', 'IMPORT');
		$cpanel_images->export = $this->CpanelButton('csvivirtuemart_export_48.png', 'index2.php?option=com_csvivirtuemart&task=export&controller=export', 'EXPORT');
		$cpanel_images->maintenance = $this->CpanelButton('csvivirtuemart_maintenance_48.png', 'index2.php?option=com_csvivirtuemart&task=maintenance&controller=maintenance', 'MAINTENANCE');
		$cpanel_images->help = $this->CpanelButton('csvivirtuemart_help_48.png', 'http://www.csvimproved.com/csv-improved-documentation/', 'HELP');
		$cpanel_images->about = $this->CpanelButton('csvivirtuemart_about_48.png', 'index2.php?option=com_csvivirtuemart&task=about&controller=about', 'ABOUT');
		$cpanel_images->log = $this->CpanelButton('csvivirtuemart_log_48.png', 'index2.php?option=com_csvivirtuemart&task=log&controller=log', 'LOG');
		$cpanel_images->availablefields = $this->CpanelButton('csvivirtuemart_av_fields_48.png', 'index2.php?option=com_csvivirtuemart&task=availablefields&controller=availablefields', 'AVAILABLE_FIELDS');
		$cpanel_images->replacement = $this->CpanelButton('csvivirtuemart_replace_48.png', 'index2.php?option=com_csvivirtuemart&task=replacement&controller=replacement', 'REPLACEMENT');
		$cpanel_images->settings = $this->CpanelButton('csvivirtuemart_settings_48.png', 'index2.php?option=com_csvivirtuemart&task=settings&controller=settings', 'SETTINGS');
		return $cpanel_images;
	}
	 /**
	* Prints a button for the control panel
	*
	* @param string $image contains the name of the image
	* @param string $link contains the target link for the image when clicked
	* @param string $title contains the title of the button
	* @return string returns a complete button for the control panel
	 */
	private function CpanelButton($image, $link, $title) {
		if (substr($link, 0, 4) == "http") $attribs = ' target="_new"';
		else $attribs = '';
		$cpanelbutton = '<div class="cpanel_button">';
		$cpanelbutton .= '	<div class="icon">';
		$cpanelbutton .= JHTML::_('link', $link, JHTML::_('image', JURI::root().'administrator/components/com_csvivirtuemart/assets/images/'.$image, JText::_($title)).'<span>'.JText::_($title).'</span>', $attribs);
		$cpanelbutton .= '	</div>';
		$cpanelbutton .= '</div>';
		return $cpanelbutton;
	}
}
?>