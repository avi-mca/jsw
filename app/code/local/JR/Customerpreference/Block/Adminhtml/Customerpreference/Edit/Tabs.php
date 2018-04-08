<?php

class JR_Customerpreference_Block_Adminhtml_Customerpreference_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('customerpreference_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('customerpreference')->__('Customer Preference'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('customerpreference')->__('General Information'),
          'title'     => Mage::helper('customerpreference')->__('General Information'),
          'content'   => $this->getLayout()->createBlock('customerpreference/adminhtml_customerpreference_edit_tab_general')->toHtml(),
      ));
      if (Mage::registry('customerpreference_data')) {
        $this->addTab('customer_members', array(
            'label'     => Mage::helper('customerpreference')->__('Family Members'),
            'class'     => 'ajax',
            'url'       => $this->getUrl('*/*/members', array('_current' => true)),
         ));
      }

      return parent::_beforeToHtml();
  }
}
