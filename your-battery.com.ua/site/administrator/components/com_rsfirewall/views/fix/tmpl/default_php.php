<?php
/**
* @version 1.0.0
* @package RSFirewall! 1.0.0
* @copyright (C) 2009-2011 www.rsjoomla.com
* @license GPL, http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die('Restricted access');
?>

<?php
if ($this->fixPHP === true)
	echo JText::_('RSF_FIX_PHP_OK');
else
{
	echo JText::_('RSF_FIX_PHP_ERROR');
	?>
	<form method="post">
	<textarea rows="6" cols="40"><?php echo $this->fixPHP ?></textarea>
	</form>
	<?php
}
?>