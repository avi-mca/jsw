<?php
class JR_Customerpreference_Block_Adminhtml_Customerpreference extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_customerpreference';
    $this->_blockGroup = 'customerpreference';
    $this->_headerText = Mage::helper('customerpreference')->__('Customer Preferences');
    $this->_addButtonLabel = Mage::helper('customerpreference')->__('Add Preference');
    parent::__construct();
  }
}
