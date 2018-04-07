<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/controllers/Adminhtml/DailystatController.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ aoQUjhmopCaTaapr('ef535db1867116b8b187ae1add595c89'); ?><?php

class AdjustWare_Cartalert_Adminhtml_DailystatController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('adjcartalert/quotestat')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Daily Statistic'), Mage::helper('adminhtml')->__('Daily Statistic'));
        return $this;
    }   
   
    public function indexAction() {
        $periodType = $this->getRequest()->getParam('period_type');
        $from = $this->getRequest()->getParam('from');
        $to = $this->getRequest()->getParam('to');        
        
        if($periodType && (!$from || !$to))
        {
            
            Mage::getSingleton('core/session')->addError($this->__('Please select correct from/to values'));
            $this->getRequest()->setParam('period_type','');
        }        
        $this->_initAction();        
        $this->_addContent($this->getLayout()->createBlock('adjcartalert/adminhtml_dailystat_cronmanage'));
        $this->_addContent($this->getLayout()->createBlock('adjcartalert/adminhtml_dailystat_filter'));        
        $this->_addContent($this->getLayout()->createBlock('adjcartalert/adminhtml_dailystat'));
        $this->renderLayout();
    }
   
	
    public function cronmanageAction()
    {
        
        $from = $this->getRequest()->getParam('from');
        $to = $this->getRequest()->getParam('to');
        $this->getResponse()->setBody(
            Mage::getModel('adjcartalert/cronstat')->createTask('AdjustWare_Cartalert_Model_Dailystat', 'collectDay', $from, $to)
        );
    }        
    
} } 