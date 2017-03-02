<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/**
*
* @version $Id: ps_product.php 1948 2009-09-30 14:32:48Z soeren_nb $
* @package VirtueMart
* @subpackage classes
* @copyright Copyright (C) 2004-2009 soeren - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See /administrator/components/com_virtuemart/COPYRIGHT.php for copyright notices and details.
*
* http://virtuemart.net
*/

/**
 * The class is is used to manage product repository.
 * @package virtuemart
 * @author pablo, jep, gday, soeren
 * 
 */
class vm_ps_search extends vmAbstractObject {
	

	function select_capacity() {
		global $vmLogger, $database, $perm, $VM_LANG;
		
		$valid = true;
		$db = new ps_DB;

		$q = "SELECT DISTINCT product_capacity FROM #__{vm}_product WHERE product_capacity >0 AND product_publish='Y' ORDER BY product_capacity ASC  ";;
		$tt= $db->setQuery($q); $db->query();
		//if ($db->next_record()&&($db->f("product_id") != $d["product_id"])) {
		//	$vmLogger->err( "A Product with the capacity >0  not exists." );
			//$valid = false;
		//}
        
        
        while ($db->next_record()){

			//$array_e[]=0;
			//for ($i=0; $i<=$db->num_rows(); $i++) {
			 
                //$pr_ech = $db->f('product_capacity');
                
                //if ($pr_ech=='60.0') {
                    //$selected = 'selected style="color:#FF0000;"';
                //}
                //else {$selected = '';}
                
				//if (!in_array($pr_ech, $array_e)) {
				    
				
					//$path_sub .= "<option value=".$pr_ech." ".$selected.">".$pr_ech."</option>";
				//}
                
                //$array_e[]=$pr_ech;			
			//}   
        //}
        
        
                $pr_echstab = $db->f('product_capacity');
                $pr_ech = $db->f('product_capacity');
                $pr_ech_expend=explode('.',$pr_ech);
                
                if ($pr_echstab =='60.0') {
                    $selected = 'selected style="color:#FF0000;"';
                }
                else {
                    
                    $selected = '';
                    
                }
                
                if ($pr_ech_expend[1]>0) {
                    $path_sub .= "<option value=".$pr_echstab.">".$pr_echstab."</option>";
                }
                else {
                    $path_sub .= "<option value=".$pr_echstab." ".$selected.">".$pr_ech_expend[0]."</option>";
                }
                unset($pr_ech); unset($pr_echstab);unset($pr_ech_expend);
        }
	   return $path_sub;
    }
}
?>
