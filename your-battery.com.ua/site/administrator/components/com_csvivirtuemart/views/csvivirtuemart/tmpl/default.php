<?php
/**
* Default page for CSV Improved
*
* @package CSVIVirtueMart
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: default.php 1119 2010-01-04 23:31:29Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );
?>

<div id="main">
	<div id="cpanel">
		<?php echo $this->cpanel_images->templates; ?>
		<?php echo $this->cpanel_images->import; ?>
		<?php echo $this->cpanel_images->export; ?>
		<?php echo $this->cpanel_images->maintenance; ?>
		<?php echo $this->cpanel_images->log; ?>
		<br class="clear" />
		<?php echo $this->cpanel_images->availablefields; ?>
		<?php echo $this->cpanel_images->replacement; ?>
		<?php echo $this->cpanel_images->settings; ?>
		<?php echo $this->cpanel_images->help; ?>
		<?php echo $this->cpanel_images->about; ?>
	</div>
</div>
