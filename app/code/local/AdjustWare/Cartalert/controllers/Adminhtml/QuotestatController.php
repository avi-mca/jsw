<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/controllers/Adminhtml/QuotestatController.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ goCpyhDopwgqggpB('85e29f88b8058eabe57a59325c7b4fbd'); ?><?php

class AdjustWare_Cartalert_Adminhtml_QuotestatController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('adjcartalert/quotestat')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Abandoned Carts Statistic'), Mage::helper('adminhtml')->__('Abandoned Cart Statistic'));
        return $this;
    }   
   
    public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('adjcartalert/adminhtml_quotestat'));
        $this->renderLayout();
    }

    public function viewAction()
    {
        $quotestatId     = $this->getRequest()->getParam('id');
        $quotestatModel  = Mage::getModel('adjcartalert/quotestat')->load($quotestatId);
 
        if ($quotestatModel->getId()) {
 
            Mage::register('quotestat_data', $quotestatModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('adjcartalert/quotestat');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Abandoned Carts Statistic'), Mage::helper('adminhtml')->__('Abandoned Carts Statistic'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Abandoned Carts Statistic'), Mage::helper('adminhtml')->__('Abandoned Carts Statistic'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
                          
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adjcartalert')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }    
    }
        
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
               $this->getLayout()->createBlock('adjcartalert/adminhtml_quotestat_grid')->toHtml()
        );
    }
	
} } 