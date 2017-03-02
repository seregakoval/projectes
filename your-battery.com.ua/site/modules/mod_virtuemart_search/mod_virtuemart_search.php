<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
* VirtueMart Search Module
* NOTE: THIS MODULE REQUIRES THE PHPSHOP COMPONENT FOR MOS!
*
* @version $Id: mod_virtuemart_search.php 1159 2008-01-14 20:30:30Z soeren_nb $
* @package VirtueMart
* @subpackage modules
*
* @copyright (C) 2004-2007 soeren
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

// Load the virtuemart main parse code
if( file_exists(dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' )) {
	require_once( dirname(__FILE__).'/../../components/com_virtuemart/virtuemart_parser.php' );
} else {
	require_once( dirname(__FILE__).'/../components/com_virtuemart/virtuemart_parser.php' );
}

if( file_exists(dirname(__FILE__).'/classes/ps_search.php' )) {
	require_once( dirname(__FILE__).'/classes/ps_search.php' );
} 

global $VM_LANG, $mm_action_url, $sess;

$search = NEW vm_ps_search;
$tt = $search->select_capacity();

?>
<!--BEGIN Search Box --> 
<form action="<?php $sess->purl( $mm_action_url."index.php?page=shop.browse" ) ?>" method="post">

	<p><label for="keyword"><div class="bg_title_mod_vm"><?php //echo $VM_LANG->_('PHPSHOP_SEARCH_LBL') ?></div></label></p>
	<table border="0" width="200px" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <p><?php echo $VM_LANG->_('PHPSHOP_SEARCH_CAPACITY_LBL') ?>:</p>
            </td>
            <td>
                <select name="keyword1" style="width: 80px;">
                <?php echo $tt ?>
                </select>
            </td>
        </tr>
    <tr>
            <td>
            <p><?php echo $VM_LANG->_('PHPSHOP_SEARCH_TEXT_LBL') ?>:</p>
            </td>
            <td>
       	        <input name="keyword" type="text" size="10" title="<?php echo $VM_LANG->_('PHPSHOP_SEARCH_TITLE') ?>" class="inputbox" id="keyword"  />
            </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
        <input src="modules/mod_virtuemart_search/images/001_38.png" type="image" name="Search" value="<?php echo $VM_LANG->_('PHPSHOP_SEARCH_TITLE') ?>" />
        </td>
    </tr>
    </table>
    
</form>
<!-- End Search Box --> 