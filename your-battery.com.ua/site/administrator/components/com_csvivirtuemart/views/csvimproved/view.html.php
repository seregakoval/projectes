<?php
/**
 * Default view
 *
 * @package CSVImproved
 * @author Roland Dalmulder
 * @link http://www.csvimproved.com
 * @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
 * @version $Id: view.html.php 666 2009-01-02 07:55:31Z Suami $
 */

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

jimport( 'joomla.application.component.view' );

/**
 * Default View
 *
 * @package CSVImproved
 */
class CsvimprovedViewCsvimproved extends JView {
	/**
	 * CSV Improved view display method
	 *
	 * @return void
	 **/
	function display($tpl = null) {
		/* Get the Cpanel images */
		$cpanel_images = new stdClass();
		$cpanel_images->templates = $this->CpanelButton('template_48.png', 'index2.php?option=com_csvimproved&task=templates&controller=templates', JText::_('Templates'));
		$cpanel_images->import = $this->CpanelButton('import_48.png', 'index2.php?option=com_csvimproved&task=import&controller=import', JText::_('Import'));
		$cpanel_images->export = $this->CpanelButton('export_48.png', 'index2.php?option=com_csvimproved&task=export&controller=export', JText::_('Export'));
		$cpanel_images->maintenance = $this->CpanelButton('maintenance_48.png', 'index2.php?option=com_csvimproved&task=maintenance&;controller=maintenance', JText::_('Maintenance'));
		$cpanel_images->help = $this->CpanelButton('help_48.png', 'http://www.csvimproved.com/wiki/doku.php/', JText::_('Help'));
		$cpanel_images->about = $this->CpanelButton('about_48.png', 'index2.php?option=com_csvimproved&task=about&controller=about', JText::_('About'));
		$cpanel_images->log = $this->CpanelButton('log_48.png', 'index2.php?option=com_csvimproved&task=log&controller=log', JText::_('LOG'));
		$cpanel_images->availablefields = $this->CpanelButton('av_fields_48.png', 'index2.php?option=com_csvimproved&task=availablefields&controller=availablefields', JText::_('AVAILABLE_FIELDS'));
		
		/* Show the toolbar */
		$this->toolbar();
		
		/* Assign data for display */
	    $this->assignRef('cpanel_images', $cpanel_images);
		
		/* Display the page */
		parent::display($tpl);
	}
	
	/**
	 * Prints a button for the control panel
	 *
	 * @param string $image contains the name of the image
	 * @param string $link contains the target link for the image when clicked
	 * @param string $title contains the title of the button
	 * @return string returns a complete button for the control panel
	 */
	function CpanelButton($image, $link, $title) {
		global $mainframe;
		$cpanelbutton = '<div class="cpanel_button">';
		$cpanelbutton .= '	<div class="icon">';
		$cpanelbutton .= '		<a href="'.$link.'"';
		if (substr($link, 0, 4) == "http") $cpanelbutton .= ' target="_new"';
		$cpanelbutton .= '      >';
		$cpanelbutton .= '			<img src="'.JURI::root().'/media/com_csvimproved/images/'.$image.'" title="'.$title.'"';
		$cpanelbutton .= '			<span>'.$title.'</span>';
		$cpanelbutton .= '		</a>';
		$cpanelbutton .= '	</div>';
		$cpanelbutton .= '</div>';
		return $cpanelbutton;
	}
	
	function toolbar() {
		JToolBarHelper::title(   JText::_('CSV Improved Control Panel'), 'csvi_logo_48.png' );
	}
}
?>
