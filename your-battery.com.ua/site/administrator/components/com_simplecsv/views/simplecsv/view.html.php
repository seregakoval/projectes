<?php
/**
 * @link http://www.roman7.com
 * @copyright (c) 2010 Roman Nagaev
 * @license GNU/GPL
 */

//no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view' );

class SimplecsvViewSimplecsv extends JView
{
    function display($tpl = null)
    {

        $model  = $this->getModel();

        if(JRequest::getVar('layout') != 'last'){
            $text = JText::_('IMPORT').'/'.JText::_('EXPORT');
            JToolBarHelper::title('SimpleCSV for VirtueMart','generic.png');
            JToolBarHelper::preferences('com_simplecsv');
            JToolBarHelper::save('load',$text);
            $vm = JComponentHelper::getComponent('com_virtuemart');
            if($vm->option){
                $categories   = $model->getCategories();
                $manufacturer = $model->getManufacturer();
                $vendor       = $model->getVendor();
                $this->assign('categories',$categories);
                $this->assign('manufacturer',$manufacturer);
                $this->assign('vendor',$vendor);
            }
            if(JRequest::getBool('debug')){
                if(file_exists(JPATH_COMPONENT.DS.'last.import')){
                    $ids = file_get_contents(JPATH_COMPONENT.DS.'last.import');
                    $ids = unserialize($ids);
                    $md5 = explode('pw', $ids, 2);
                    $ids = $md5[0];
                    $md5 = $md5[1];
                    if($md5 == md5($ids)){
                        $debug = $model->_getDebug($ids);
                    }else{
                        $debug = JText::_('LAST IMPORT ERROR FILEINCORRECT');
                    }
                }else{
                    $debug = JText::_('LAST IMPORT ERROR FILE');
                }
                $this->assign('debug',$debug);
            }
        }else{
            $text = $text = JText::_('CANCEL').' '.JString::strtolower(JText::_('IMPORT'));
            JToolBarHelper::title('SimpleCSV for VirtueMart','generic.png');
            JToolBarHelper::save('last');
        }
        
        parent::display($tpl);
        
    }
}