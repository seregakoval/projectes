<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<?php foreach ($this->fixJUMI as $file) { ?>
<strong><?php echo JText::_($file->what); ?>:</strong> <?php echo $file->file; ?><br />
<?php } ?>

<?php echo JText::_('RSF_JUMI_FIX_DESC'); ?>