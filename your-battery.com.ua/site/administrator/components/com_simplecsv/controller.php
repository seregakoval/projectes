<?php
/**
 * @link http://www.roman7.com
 * @copyright (c) 2010 Roman Nagaev
 * @license GNU/GPL
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class SimplecsvController extends JController
{

    function display()
    {
        parent::display();
    }

    function load()
    {
        //model
        $model = $this->getModel();

        //mode
        $mode = JRequest::getWord('mode','import');

        //dividers
        $divider_field = JRequest::getVar('divider_field',',');
        switch($divider_field){
            case 'colon':
            $divider_field = ':';
            break;
            case 'semicolon':
            $divider_field = ';';
            break;
            case 'space':
            $divider_field = ' ';
            break;
            default:
            $divider_field = ',';
            break;
        }
        $divider_text  = JRequest::getVar('divider_text','');
        switch($divider_text){
            case 'quote':
            $divider_text = '"';
            break;
            case 'apos':
            $divider_text = "'";
            break;
            default:
            $divider_text = '';
            break;
        }

        //fields
        $fields = array();

        $fields['category_id']        = JRequest::getBool('category_id',null)!==null?JRequest::getInt('category_id_order'):'none';
        $fields['category_id_one']    = JRequest::getBool('category_id_one',null)!==null?JRequest::getInt('category_id_one_order'):'none';
        $fields['product_sku']        = JRequest::getBool('product_sku',null)!==null?JRequest::getInt('product_sku_order'):'none';
        $fields['product_name']       = JRequest::getBool('product_name',null)!==null?JRequest::getInt('product_name_order'):'none';
        $fields['manufacturer_id']    = JRequest::getBool('manufacturer_id',null)!==null?JRequest::getInt('manufacturer_id_order'):'none';
        $fields['product_price']      = JRequest::getBool('product_price',null)!==null?JRequest::getInt('product_price_order'):'none';
        
        //
        $fields['product_voltage']      = JRequest::getBool('product_voltage',null)!==null?JRequest::getInt('product_voltage_order'):'none';
        $fields['product_capacity']      = JRequest::getBool('product_capacity',null)!==null?JRequest::getInt('product_capacity_order'):'none';
        $fields['product_starting']      = JRequest::getBool('product_starting',null)!==null?JRequest::getInt('product_starting_order'):'none';
        $fields['product_thumb_image']      = JRequest::getBool('product_thumb_image',null)!==null?JRequest::getInt('product_thumb_image_order'):'none';
        $fields['product_full_image']      = JRequest::getBool('product_full_image',null)!==null?JRequest::getInt('product_full_image_order'):'none';
        //
        //
        
        
        $fields['product_currency']   = JRequest::getBool('product_currency',null)!==null?JRequest::getInt('product_currency_order'):'none';
        $fields['product_s_desc']     = JRequest::getBool('product_s_desc',null)!==null?JRequest::getInt('product_s_desc_order'):'none';
        $fields['product_desc']       = JRequest::getBool('product_desc',null)!==null?JRequest::getInt('product_desc_order'):'none';
        $fields['vendor_id']          = JRequest::getBool('vendor_id',null)!==null?JRequest::getInt('vendor_id_order'):'none';
        $fields['product_publish']    = JRequest::getBool('product_publish',null)!==null?JRequest::getInt('product_publish_order'):'none';
        $fields['product_weight']     = JRequest::getBool('product_weight',null)!==null?JRequest::getInt('product_weight_order'):'none';
        $fields['product_weight_uom'] = JRequest::getBool('product_weight_uom',null)!==null?JRequest::getInt('product_weight_uom_order'):'none';
        $fields['product_length']     = JRequest::getBool('product_length',null)!==null?JRequest::getInt('product_length_order'):'none';
        $fields['product_width']      = JRequest::getBool('product_width',null)!==null?JRequest::getInt('product_width_order'):'none';
        $fields['product_height']     = JRequest::getBool('product_height',null)!==null?JRequest::getInt('product_height_order'):'none';
        $fields['product_lwh_uom']    = JRequest::getBool('product_lwh_uom',null)!==null?JRequest::getInt('product_lwh_uom_order'):'none';

        //csv
        $csv              = JRequest::getVar('csv',null,'files');
        $csv_maxfilesize  = ini_get('upload_max_filesize');
        $csv_exts         = array('csv','txt');
        $csv_ext          = substr($csv['name'],strrpos($csv['name'], '.') + 1);
        
        //обработка
        $fields = array_diff($fields,array('none'));
        $start  = count($fields); //количество активных полей
        $fields = array_diff($fields,array(0));
        $fields = array_flip($fields);
        $last   = array_keys($fields); //порядковый номер последнего поля
        sort($last);
        $last   = array_pop($last); //количество корректных полей
        ksort($fields); //обработанные поля
        $fields = array_values($fields);
        $end    = count($fields); //количество корректных полей

        $vm = JComponentHelper::getComponent('com_virtuemart');

        if($mode == 'export')
        {
            $model->export($fields,$divider_field,$divider_text);
        }
        elseif(!$vm->option){
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('IMPORT ERROR VM'),'error');
        }
        elseif($start != $end || $end < $last)
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD ORDER'),'error');
        }
        elseif(!in_array('category_id',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD CATEGORY'),'error');
        }
        elseif(!in_array('product_name',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD NAME'),'error');
        }
        
        //
        elseif(!in_array('product_capacity',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD NAME'),'error');
        }
        elseif(!in_array('product_starting',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD NAME'),'error');
        }
        elseif(!in_array('product_voltage',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD NAME'),'error');
        }
        //
        
        elseif(!in_array('product_sku',$fields))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('ERROR FIELD SKU'),'error');
        }
        elseif($mode == 'import' && $csv['error'] == UPLOAD_ERR_NO_FILE)
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('UPLOAD ERR NO FILE'),'error');
        }
        elseif($mode == 'import' && $csv['error'] == UPLOAD_ERR_PARTIAL)
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('UPLOAD ERR PARTIAL'),'error');
        }
        elseif($mode == 'import' && $csv['error'] == UPLOAD_ERR_INI_SIZE)
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('UPLOAD ERR INI SIZE').' '.$csv_maxfilesize,'error');
        }
        elseif($mode == 'import' && !in_array($csv_ext,$csv_exts))
        {
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('UPLOAD ERR EXT'),'error');
        }
        elseif($mode == 'import' && $csv['error'] == UPLOAD_ERR_OK)
        {
            //импорт информации
            if($model->check(fopen($csv['tmp_name'],'r'),$fields,$divider_field,$divider_text,$csv['tmp_name']))
            {
                $import = $model->import();
                if($import)
                {
                    if($model->getDebug()){
                        $debug = "&debug=1";
                    }else{
                        $debug = "";
                    }
                    if($import[0] != 0){
                        $this->setRedirect('index.php?option=com_simplecsv'.$debug,JText::_('CSV IMPORT OK').' - '.$import[0].' '.JText::_('CSV IMPORT OF').' '.$import[1],'message');
                    }else{
                        $this->setRedirect('index.php?option=com_simplecsv'.$debug,JText::_('CSV IMPORT ERROR'),'error');
                    }
                }
                else
                {
                    $this->setRedirect('index.php?option=com_simplecsv',JText::_($model->getErrorMsg()),'error');
                }
            }
            else
            {
                $this->setRedirect('index.php?option=com_simplecsv',JText::_($model->getErrorMsg()),'error');
            }
        }
        $this->display();
    }

    function last()
    {
        $last = JRequest::getVar('lastImport');
        $vm = JComponentHelper::getComponent('com_virtuemart');
        if(!$vm->option){
            $this->setRedirect('index.php?option=com_simplecsv',JText::_('IMPORT ERROR VM'),'error');
        }
        elseif($last == 'cancel')
        {
            if(file_exists(JPATH_COMPONENT.DS.'last.import')){
                $ids = file_get_contents(JPATH_COMPONENT.DS.'last.import');
                $ids = unserialize($ids);
                $md5 = explode('pw', $ids, 2);
                $ids = $md5[0];
                $md5 = $md5[1];
                if($md5 == md5($ids)){
                    $dbo = JFactory::getDBO();
                    $result = array();
                    $query[] = "DELETE FROM #__vm_product WHERE product_id IN ($ids)";
                    $query[] = "DELETE FROM #__vm_product_price WHERE product_id IN ($ids)";
                    $query[] = "DELETE FROM #__vm_product_category_xref WHERE product_id IN ($ids)";
                    $query[] = "DELETE FROM #__vm_product_mf_xref WHERE product_id IN ($ids)";
                    foreach($query as $value){
                        $dbo->setQuery($value);
                        $result[] = $dbo->query();
                    }
                    if(!in_array(false,$result)){
                        $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT CANCEL OK'),'message');
                    }else{
                        $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT CANCEL ERROR'),'error');
                    }
                    @unlink(JPATH_COMPONENT.DS.'last.import');
                }else{
                    $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT ERROR FILEINCORRECT'),'error');
                }
            }else{
                $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT ERROR FILE'),'error');
            }
        }
        elseif($last == 'delete')
        {
            if(file_exists(JPATH_COMPONENT.DS.'last.import')){
                @unlink(JPATH_COMPONENT.DS.'last.import');
                $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT DELETE'),'message');
            }else{
                $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT ERROR FILE'),'error');
            }
        }
        else
        {
            $this->setRedirect('index.php?option=com_simplecsv&layout=last',JText::_('LAST IMPORT ERROR TASK'),'error');
        }
    }
}