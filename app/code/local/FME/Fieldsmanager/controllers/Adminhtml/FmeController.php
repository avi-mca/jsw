<?php

class FME_Fieldsmanager_Adminhtml_FmeController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
       $this->loadLayout()
            ->_setActiveMenu('fieldsmanager/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Fields Manager'), Mage::helper('adminhtml')->__('Fields Manager'));
        $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        $this->renderLayout();
    }

    protected function _isAllowed()
    {
        return true;
    }
}
