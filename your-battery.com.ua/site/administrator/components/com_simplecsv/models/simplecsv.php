<?php
/**
 * @link http://www.roman7.com
 * @copyright (c) 2010 Roman Nagaev
 * @license GNU/GPL
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.model' );

class SimplecsvModelSimplecsv extends JModel
{

    /*
     * @var array
     */
    var $_fields = array('category_id','product_name','product_voltage','product_capacity','product_starting','product_thumb_image','product_full_image','product_sku','product_publish','product_price','product_currency','product_s_desc','product_desc',
                         'vendor_id','manufacturer_id','product_weight','product_weight_uom','product_length','product_width','product_height','product_lwh_uom');
    
    /*
     * 
     */
    var $_error = false;

    /*
     * @var string
     */
    var $_errorMsg = null;

    /*
     * @var array
     */
    var $_data = null;

    /*
     * @var array
     */
    var $_categories_id = null;

    /*
     * @var array
     */
    var $_fieldsData = null;

    /*
     * @var integer
     */
    var $_fieldsCount = null;

    /*
     * @var array
     */
    var $_checks = array();

    /*
     * @var bool
     */
    var $_debug = false;

    /*
     * @var array
     */
    var $_ids = null;

    function __construct($debug = false)
    {
        $params = JComponentHelper::getParams('com_simplecsv');
        $debug = $params->get('debug');
        $this->_debug = $debug;
        parent::__construct();
    }

    function getDebug()
    {
        return $this->_debug;
    }

    function getCategories()
    {
        static $categories = null;
        if($categories === null){
            $query = "SELECT * FROM #__vm_category";
            $categories = $this->_getList($query);
            for($i=0,$sum=count($categories);$i<$sum;$i++){
                $this->_categories_id[] = $categories[$i]->category_id;
            }
            return $categories;
        }else{
            return $categories;
        }
    }

    function getManufacturer()
    {
        static $manufacturer = null;
        if($manufacturer === null){
            $dbo = $this->getDBO();
            $query = "SELECT manufacturer_id,mf_name FROM #__vm_manufacturer LIMIT 0,1";
            $dbo->setQuery($query);
            $manufacturer = $dbo->loadObject();
            return $manufacturer;
        }else{
            return $manufacturer;
        }       
    }

    function getVendor()
    {
        static $vendor = null;
        if($vendor === null){
            $dbo = $this->getDBO();
            $query = "SELECT vendor_id,vendor_name FROM #__vm_vendor LIMIT 0,1";
            $dbo->setQuery($query);
            $vendor = $dbo->loadObject();
            return $vendor;
        }else{
            return $vendor;
        }
    }

    function getSKU()
    {

        $dbo = $this->getDBO();
        $query = "SELECT product_sku FROM #__vm_product GROUP BY product_sku";
        $dbo->setQuery($query);
        return $dbo->loadResultArray();
    }

    function getShopperDefault()
    {

        $dbo = $this->getDBO();
        $query = "SELECT shopper_group_id FROM #__vm_shopper_group WHERE `default`=1";
        $dbo->setQuery($query);
        return $dbo->loadResult();
    }

    function isVendor($vendor_id){
        static $vendors = array();
        if((in_array($vendor_id, $vendors))){
           return true;
        }
        $query = "SELECT vendor_id FROM #__vm_vendor WHERE vendor_id=$vendor_id";
        $result = $this->_getList($query);
        if(count($result)){
            $vendors[] = $result[0]->vendor_id;
            return true;
        }else{
            return false;
        }
    }

    function isManufacturer($manufacturer_id){
        static $manufacturers = array();
        if((in_array($manufacturer_id, $manufacturers))){
           return true;
        }
        $query = "SELECT manufacturer_id FROM #__vm_manufacturer WHERE manufacturer_id=$manufacturer_id";
        $result = $this->_getList($query);
        if(count($result)){
            $manufacturers[] = $result[0]->manufacturer_id;
            return true;
        }else{
            return false;
        }
    }

    function getErrorMsg()
    {
        return $this->_errorMsg;
    }

    function setErrorMsg($msg)
    {
        $this->_errorMsg = $msg;
    }

    function export($fields,$divider_field,$divider_text)
    {       
        for($i=0,$sum=count($fields);$i<$sum;$i++){
            switch($fields[$i]){
                case 'product_currency':
                case 'product_price':
                $fields[$i] = 'pr.'.$fields[$i];
                break;
                case 'category_id':
                $fields[$i] = 'c.'.$fields[$i];
                break;
                case 'manufacturer_id':
                $fields[$i] = 'm.'.$fields[$i];
                break;
                default:
                $fields[$i] = 'p.'.$fields[$i];
                break;
            }
        }
        $fields = implode(',',$fields);
        $path = JPATH_COMPONENT.DS."export.csv";
        $query = "SELECT $fields
                  FROM #__vm_product p,#__vm_product_category_xref c,#__vm_product_mf_xref m,#__vm_product_price pr
                  WHERE p.product_id=c.product_id
                    AND p.product_id=m.product_id
                    AND p.product_id=pr.product_id
                  ";
        $dbo = $this->getDBO();
        $dbo->setQuery($query);
        $export = $dbo->loadRowList();
        for($i=0,$sum=count($export);$i<$sum;$i++){
            $out .= $divider_text.implode($divider_text.$divider_field.$divider_text,$export[$i]).$divider_text;
            $out .= "\r\n";
        }
        ob_end_clean();
        header('Content-Disposition: attachment; filename=export.csv');
        echo $out;
        exit;
    }

    function import()
    {
        $dbo = $this->getDBO();
        $data   = $this->_data;
        $fields = $this->_fieldsData;
        $import_counter = 0;
        $field_counter  = 0;
        $debug = $this->_debug;
        $shopper_group_id = $this->getShopperDefault();

        $fields_product = array_flip($fields);
        $category_id = $fields_product['category_id'];
        unset($fields_product['category_id']);
        $product_price = $fields_product['product_price'];
        unset($fields_product['product_price']);
        $product_currency = $fields_product['product_currency'];
        unset($fields_product['product_currency']);
        $manufacturer_id = $fields_product['manufacturer_id'];
        unset($fields_product['manufacturer_id']);
        $fields_product = array_flip($fields_product);

        $quote = array();
        foreach($fields as $key=>$value){
            switch($value){
                case 'product_name':
                $quote[] = $key;
                break;
                case 'product_sku':
                $quote[] = $key;
                break;
                
                case 'product_thumb_image':
                $quote[] = $key;
                case 'product_full_image':
                $quote[] = $key;
                
                case 'product_s_desc':
                $quote[] = $key;
                break;
                case 'product_desc':
                $quote[] = $key;
                break;
                case 'product_publish':
                $quote[] = $key;
                break;
                case 'product_weight_uom':
                $quote[] = $key;
                break;
                case 'product_lwh_uom':
                $quote[] = $key;
                break;
            }
        }

        $add = array();
        if(!in_array('vendor_id',$fields)){
            $add1 = $this->getVendor();
            $add['vendor_id']  = $add1->vendor_id;
        }
        if(!in_array('manufacturer_id',$fields)){
            $manufacturer_id_val = $this->getManufacturer();
            $manufacturer_id_val  = $manufacturer_id_val->manufacturer_id;
        }
        if(!in_array('product_publish',$fields)){
            $product_publish_val = 'Y';
        }
        $add_count = count($add);

        $keys = implode(',',$fields_product);
        $values = '';

        for($i=0,$sum=count($data);$i<$sum;$i++){
            if(!$values){
                for($j=0,$sum2=count($data[$i]);$j<$sum2;$j++){
                    $data[$i][$j] = $dbo->getEscaped($data[$i][$j]);
                    if(isset($fields_product[$j])){
                        if(in_array($j,$quote)){
                            $data[$i][$j] = "'".$data[$i][$j]."'";
                        }
                        $values .= $data[$i][$j].',';
                    }
                }
                
                
                $cat_id = $data[$i][$category_id];
                if($product_price){
                    if($data[$i][$product_price]){
                        $product_price_val = $data[$i][$product_price];
                    }else{
                        $product_price_val = "''";
                    }
                }else{
                    $product_price_val = "''";
                }
                if($product_currency){
                    $product_currency_val = $data[$i][$product_currency];
                }else{
                    $product_currency_val = "'USD'";
                }
                if(!isset($manufacturer_id_val)){
                    $manufacturer_id_val = $data[$i][$manufacturer_id];
                }
                $values = rtrim($values, ',');
            }

            if($add_count){
                $add_values = implode(',',$add);
                $add_values = ','.$add_values;
                $add_keys = implode(',',array_keys($add));
                $add_keys = ','.$add_keys;
            }else{
                $add_keys = '';
                $add_values = '';
            }
            if(isset($product_publish_val)){
                $add_keys .= ",product_publish";
                $add_values .= ",'Y'";
            }
            $query = "INSERT INTO #__vm_product ({$keys}{$add_keys}) VALUES({$values}{$add_values})";
            $dbo->setQuery($query);
            $product = $dbo->query();
            $product_id = $dbo->insertid();
            if(!$product || (int)$product_id == 0){
                continue;
            }

            
            if($product && $product_id){
                $this->_ids[] = $product_id;
            }

            $field_counter++;

            $query2 = "INSERT INTO #__vm_product_category_xref (category_id,product_id) VALUES($cat_id,$product_id)";
            $dbo->setQuery($query2);
            if(!$dbo->query()){
                $product_id = (int)$product_id;
                $query_del = "DELETE FROM #__vm_product WHERE product_id=$product_id";
                $dbo->setQuery($query_del);
                $dbo->query();
            }else{
                $query3 = "INSERT INTO #__vm_product_mf_xref (product_id,manufacturer_id) VALUES($product_id,$manufacturer_id_val)";
                $dbo->setQuery($query3);
                if(!$dbo->query()){
                    $product_id = (int)$product_id;
                    $query_del = "DELETE FROM #__vm_product WHERE product_id=$product_id";
                    $dbo->setQuery($query_del);
                    $dbo->query();
                    $query_del = "DELETE FROM #__vm_product_category_xref WHERE product_id=$product_id";
                    $dbo->setQuery($query_del);
                    $dbo->query();
                }else{
                    $query4 = "INSERT INTO #__vm_product_price (product_price,product_id,product_price_vdate,product_price_edate,cdate,mdate,product_currency,shopper_group_id) VALUES($product_price_val,$product_id,0,0,UNIX_TIMESTAMP(),UNIX_TIMESTAMP(),$product_currency_val,$shopper_group_id)";
                    $dbo->setQuery($query4);
                    if(!$dbo->query()){
                        $product_id = (int)$product_id;
                        $query_del = "DELETE FROM #__vm_product WHERE product_id=$product_id";
                        $dbo->setQuery($query_del);
                        $dbo->query();
                        $query_del = "DELETE FROM #__vm_product_category_xref WHERE product_id=$product_id";
                        $dbo->setQuery($query_del);
                        $dbo->query();
                        $query_del = "DELETE FROM #__vm_product_mf_xref WHERE product_id=$product_id";
                        $dbo->setQuery($query_del);
                        $dbo->query();
                    }else{
                        $import_counter++;
                    }
                }
            }
            
            $values = '';
            
        }

        if($this->_ids != null){
            $file = fopen(JPATH_COMPONENT.DS.'last.import', 'wb');
            $ids = implode(',', $this->_ids);
            $ids .= 'pw'.md5($ids);
            $ids = serialize($ids);
            fwrite($file, $ids);
            fclose($file);
        }
        
        return array($import_counter,$field_counter);
    }

    function check($fd,$fields,$divider_field,$divider_text,$file)
    {
        $this->_fieldsData  = $fields; //импортируемые поля
        $this->_fieldsCount = count($fields);

        //проверка корректности поля
        foreach($fields as $field){
            if(!in_array($field,$this->_fields)){
                $this->setErrorMsg('CSV FIELD INCORRECT');
                return false;
            }
        }

        $data = array();
        if(!$divider_text){
            $divider_text = "~";
        }

        $c = 0;
        while($_data = fgetcsv($fd,10000,$divider_field,$divider_text)){
            if(count($_data) == 1){
                $c++;
                continue;
            }
            $_data = $this->_checkFields($_data);
            if($_data){
                $data[] = $_data;
            }else{
                return false;
            }
        }

        $sku = $this->getSKU();
        $product_sku = $this->_checks['product_sku'];
        $product_sku = array_merge($product_sku, $sku); 

        if(count($data) == 0){
            $this->setErrorMsg('CSV IMPORT ERROR');
            return false;
        }
        
        if(count($data)+$c != count(file($file))){
            $this->setErrorMsg('CSV ERROR');
            return false;
        }

        if(count($product_sku) != count(array_flip($product_sku))){
            $this->setErrorMsg('ERROR SKU UNIQUE');
            return false;
        }
        
        $this->_data = $data;

        return true;
    }

    function _checkFields($data)
    {
        $fields = $this->_fieldsData;
        $count  = $this->_fieldsCount;
        $filter = JFilterInput::getInstance();
        if($this->_categories_id == null){
            $this->getCategories();
        }

        if(count($data) != $count){
            $this->setErrorMsg('CSV FIELD COUNT');
            return false;
        }
        
        for($i=0;$i<$count;$i++){
            switch($fields[$i]){
                case 'category_id':
                $data[$i] = (int)trim($data[$i],'int');
                if(!in_array($data[$i],$this->_categories_id)){
                    $this->setErrorMsg('CSV FIELD CATEGORY INCORRECT');
                    return false;
                }
                break;
                case 'product_sku':
                $this->_checks['product_sku'][] = $data[$i];
                break;
                
                case 'product_publish':
                $data[$i] = trim($data[$i]) == 'N'?'N':'Y';
                break;
                case 'manufacturer_id':
                if(!$this->isManufacturer($data[$i])){
                    $this->setErrorMsg('CSV FIELD MANUFACTURER INCORRECT');
                    return false;
                }
                case 'vendor_id':
                if(!$this->isVendor($data[$i])){
                    $this->setErrorMsg('CSV FIELD VENDOR INCORRECT');
                    return false;
                }
                break;
                case 'product_price':
                $data[$i] = (float)$data[$i];
                if(!preg_match('/^[0-9.]+$/',$data[$i])){
                    $data[$i] = '';
                }
                break;
                case 'product_length':
                case 'product_width':
                case 'product_height':
                case 'product_weight':
                $data[$i] = $filter->clean($data[$i],'float');
                break;
                case 'product_name':
                case 'product_lwh_uom':
                case 'product_weight_uom':
                case 'product_s_desc':
                case 'product_desc':
                $iconv = iconv("windows-1251", "UTF-8", $data[$i]);
                if($iconv){
                    $data[$i] = $iconv;
                }
                $filter_desc = JFilterInput::getInstance(0,0,1,1);
                $data[$i] = $filter_desc->clean($data[$i],'string');
                break;
                case 'product_currency':
                $data[$i] = $filter->clean(trim($data[$i]),'string');
                break;
                
                case 'product_thumb_image':
                case 'product_full_image':
                $data[$i] = trim($data[$i]);
                break;

                default:
                $data[$i] = $filter->clean($data[$i],'string');
                break;
            }
        }

        return $data;
    }

    function _getLastId()
    {
        $dbo = $this->getDBO();
        $query = "SELECT MAX(product_id) AS product_id FROM #__vm_product";
        $dbo->setQuery($query);
        return $dbo->loadResult();
    }

    function _getDebug($ids)
    {
        $query = "SELECT category_id,manufacturer_id,p.product_id,product_name,product_starting,product_capacity,product_voltage,product_thumb_image,product_full_image,product_sku,product_publish,product_price,product_s_desc,product_desc,
                         vendor_id,product_weight,product_weight_uom,product_length,product_width,product_height,product_lwh_uom
                  FROM #__vm_product AS p,#__vm_product_category_xref AS c,#__vm_product_price AS pr,#__vm_product_mf_xref AS m
                  WHERE p.product_id=c.product_id
                    AND p.product_id=pr.product_id
                    AND p.product_id=m.product_id
                    AND p.product_id IN ($ids)
                  ";
        return $this->_getList($query);
    }
    
}