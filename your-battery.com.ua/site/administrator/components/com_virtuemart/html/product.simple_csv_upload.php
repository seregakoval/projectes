<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' ); 
/**
*
* @version $Id: product.csv_upload.php,v 1.4.2.1 2006/03/10 15:55:15 soeren_nb Exp $
* @package VirtueMart
* @subpackage html
* @copyright Copyright (C) 2004-2005 Soeren Eberhardt. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/
mm_showMyFileName( __FILE__ );

require_once(CLASSPATH.'ps_simple_csv.php');
$temp_class_storage = $mosConfig_absolute_path.'/media/'.mosGetParam($_REQUEST, 'temp', '.');
$temp_class_action = mosGetParam($_REQUEST, 'action', 'continue');
if( $temp_class_storage && file_exists($temp_class_storage) && is_file($temp_class_storage) ) {
  $ps_simple_csv = file_get_contents($temp_class_storage);
  if( $ps_simple_csv = unserialize($ps_simple_csv) ) {
    switch($temp_class_action) {
      case 'delete':
        if( file_exists($ps_simple_csv->csv_file) && is_file($ps_simple_csv->csv_file) ) unlink($ps_simple_csv->csv_file);
        unset($ps_simple_csv);
        unlink($temp_class_storage);        
        break;
        
      case 'upload':
      default:
        $ps_simple_csv->upload_csv();
        break;      
    }                                    
  }
  else {
    $vmLogger->crit('Невозможно продолжить обработку.');
    unlink($temp_class_storage);
  }
}

$temp_directory = dirname($temp_class_storage).'/';
if (is_dir($temp_directory)) {
  if ($dh = opendir($temp_directory)) {
    while (($filename = readdir($dh)) !== false) {
      if( substr($filename, 0, 3) == 'vmt' ) {
        $ps_simple_csv = file_get_contents($temp_directory.$filename);
        if( $ps_simple_csv = unserialize($ps_simple_csv) ) {
          if( file_exists($ps_simple_csv->csv_file) && is_file($ps_simple_csv->csv_file) ) {
            $info = stat($temp_directory.$filename); 
               
            $size = filesize($ps_simple_csv->csv_file);         
            $i = 0;
            $iec = array("B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");
            while ( ($size / 1024) > 1 ) {
             $size = $size / 1024;
             $i++;
            }
            $filesize = substr( $size, 0, strpos($size, '.') + 4 ).' '.$iec[$i];
            
            $html[] = array (
              basename($ps_simple_csv->csv_file),
              $filesize,
              date('d.m.Y H:i:s', $info[10]),
              date('d.m.Y H:i:s', $info[9]),
              '<a href="'.$sess->url('index.php?page=product.simple_csv_upload&temp='.$filename).'">Продолжить</a>',
              '<a href="'.$sess->url('index.php?page=product.simple_csv_upload&temp='.$filename.'&action=delete').'">Удалить</a>',
            );
          }
          else {
            unlink($temp_directory.$filename);
          } 
        }
        else {
          unlink($temp_directory.$filename);
        }
      }
    }
    closedir($dh);
  }
}

$ps_simple_csv = new ps_simple_csv();

if ( (float)substr(phpversion(), 0, 3) >= 4.3) {
	$show_fec = true;
  $cols = 4;
}
else {
  $show_fec = false;
  $cols = 2;
}

?>
<img src="<?php echo IMAGEURL ?>ps_image/csv.gif" alt="CSV Upload" border="0" />
<span class="sectionname"><?php echo $VM_LANG->_PHPSHOP_PRODUCT_CSV_UPLOAD ?></span><br /><br />

<table class="adminform" border="0">
  <tr>
    <td>
      <table style="border-right: 1px solid;" class="adminform">
        <tr>
          <th colspan="4"><?php echo $VM_LANG->_PHPSHOP_CSV_SETTINGS ?></th>
        </tr>
        <tr>
          <td valign="top" width="15%" align="right" <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" name="adminForm" enctype="multipart/form-data">
            <input type="hidden" name="func" value="product_simple_csv" />
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="upload_identifier" value="" />                      
            <input type="hidden" name="page" value="product.simple_csv_upload" />
            <input type="hidden" name="option" value="com_virtuemart" />
            <input type="hidden" name="no_html" value="0" />
            <?php echo $VM_LANG->_PHPSHOP_CSV_DELIMITER ?>:
          </td>
          <td valign="top" width="5%" <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>>
            <input type="radio" name="csv_delimiter" value="," /><span class="sectionname">,</span><br />
            <input type="radio" name="csv_delimiter" checked="checked" value=";" /><span class="sectionname">;</span><br/>
            <input type="radio" name="csv_delimiter" value="other" /><input type="text" name="other_delimiter" size="1" value="|" />
          </td>
          <?php if( $show_fec ) { ?>
          <td valign="top" width="10%" align="right"><?php echo $VM_LANG->_PHPSHOP_CSV_ENCLOSURE ?>:</td>
          <td valign="top" width="15%">
            <input type="radio" name="csv_enclosurechar" value='"' /> <span class="sectionname">"</span><br />
            <input type="radio" name="csv_enclosurechar" value="'" /> <span class="sectionname">'</span><br />
            <input type="radio" name="csv_enclosurechar" value="other" checked="checked" /><input type="text" name="other_enclosurechar" size="1" value="" />
          </td>
          <?php } ?>
        </tr>
        <tr>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>>Проверять товары?</td>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>><input type="checkbox" name="check_products" value="1" /></td>
        </tr>
        <tr>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>>Максимум строк за раз (0 - без ограничений)</td>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>><input type="text" name="line_limit" value="500" /></td>
        </tr>
        <tr>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>>Максимум секунда за раз (0 - без ограничений)</td>
          <td <?php ( $show_fec ) ? 'colspan="2"' : ''; ?>><input type="text" name="time_limit" value="25" /></td>
        </tr>
        <tr>
          <th colspan="2"><?php echo $VM_LANG->_PHPSHOP_CSV_UPLOAD_FILE ?></th>
          <th colspan="2"><?php echo $VM_LANG->_PHPSHOP_CSV_FROM_DIRECTORY ?></th>
        </tr>
        <tr>
          <td align="center" colspan="2">
            <input type="file" name="file" /> <br />
            <a href="#" onclick="javascript: adminForm.local_csv_file.value=''; submitbutton();" >
            <img alt="Import" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/upload_f2.png" align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_SUBMIT_FILE ?></a>
          </td>
          <td align="center" colspan="2">
            <input type="text" size="60" value="<?php echo realpath($mosConfig_absolute_path."/media") ?>" name="local_csv_file" /><br />
            <a href="#" onclick="javascript: submitbutton();" >
            <img alt="Import" border="0" src="<?php echo $mosConfig_live_site ?>/administrator/images/upload_f2.png" align="center" /><?php echo $VM_LANG->_PHPSHOP_CSV_FROM_SERVER ?></a>
            </form>
          </td>
        </tr>
        <?php if( $html ) { ?>
        <tr>
          <td colspan="4">
            <table width="100%" border="0" cellspacing="1" cellpadding="3">
              <tr>
                <th>Имя файла</th>
                <th>Размер</th>
                <th>Дата создания</th>
                <th>Дата последней обработки</th>
                <th colspan="2">Действия</th>
              </tr>
              <?php
                foreach( $html as $row ) {
                  echo '<tr>';                   
                  foreach($row as $key => $value) {
                    echo '<td>'.$value.'</td>';
                  }                   
                  echo '</tr>';
                }            
              ?>
            </table>
          </td>
        </tr>      
        <?php } ?>
        <?php if( $vmLogger->_temp_messages ) { ?>
        <tr>
          <td colspan="4"><?php $vmLogger->_messages = $vmLogger->_temp_messages; unset($vmLogger->_temp_messages); $vmLogger->printLog(); ?></td>
        </tr>
        <?php } ?>
      </table>
    </td>
  </tr>
</table>