<?php
/**
* Settings page
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: settings.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
	<?php
	echo $this->pane->startPane("det-pane");
		echo $this->pane->startPanel( JText::_('SETTINGS_GENERAL_SETTINGS'), 'general_settings' );
			echo $this->loadTemplate('general');
		echo $this->pane->endPanel();
		echo $this->pane->startPanel( JText::_('SETTINGS_IMPORT_SETTINGS'), 'import_settings' );
			echo $this->loadTemplate('import');
		echo $this->pane->endPanel();
		echo $this->pane->startPanel( JText::_('SETTINGS_GOOGLE_BASE_SETTINGS'), 'google_base_settings' );
			echo $this->loadTemplate('google_base');
		echo $this->pane->endPanel();
	echo $this->pane->endPane(); 
	?>
	<input type="hidden" name="option" value="com_csvivirtuemart" />
	<input type="hidden" name="controller" value="settings" />
	<input type="hidden" name="task" value="save" />
</form>