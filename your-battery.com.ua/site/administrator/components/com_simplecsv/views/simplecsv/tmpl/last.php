<?php
//no direct access
defined('_JEXEC') or die('Restricted access');
?>
<form action="" method="post" name="adminForm" id="adminForm">
    <fieldset>
    <legend><?php echo JText::_('LAST IMPORT'); ?></legend>
        <div>
            <input type="radio" name="lastImport" value="cancel" /> <?php echo JText::_('CANCEL LAST IMPORT'); ?>
        </div>
        <div>
            <input type="radio" name="lastImport" value="delete" /> <?php echo JText::_('DELETE LAST IMPORT'); ?>
        </div>
    </fieldset>
    <input type="hidden" name="option" value="com_simplecsv" />
    <input type="hidden" name="task" value="last" />
    <input type="hidden" name="layout" value="last" />
</form>