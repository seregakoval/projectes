<?php
/**
* Import product options
*
* @package CSVIVirtueMart
* @subpackage Import
* @author Roland Dalmulder
* @link http://www.csvimproved.com
* @copyright Copyright (C) 2006 - 2010 RolandD Cyber Produksi
* @version $Id: import_productimport.php 1117 2010-01-01 21:39:52Z Roland $
 */
 
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' ); 
?>
<table class="adminlist">
	<thead>
		<tr><th colspan="2"><?php echo JText::_('General import options'); ?></th></tr>
	</thead>
	<tbody>
		<?php
		echo $this->loadTemplate('importlocation');
		?>
	</tbody>
</table>
