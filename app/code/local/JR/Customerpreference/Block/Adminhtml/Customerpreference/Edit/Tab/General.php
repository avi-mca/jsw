<?php

class JR_Customerpreference_Block_Adminhtml_Customerpreference_Edit_Tab_General extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('customerpreference_form', array('legend'=>Mage::helper('customerpreference')->__('General information')));

      $fieldset->addField('fullname', 'text', array(
          'label'     => Mage::helper('customerpreference')->__('Fullname'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'fullname',
      ));

      $fieldset->addField('budget_from', 'text', array(
          'label'     => Mage::helper('customerpreference')->__('Budget From'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'budget_from',
      ));

      $fieldset->addField('budget_to', 'text', array(
          'label'     => Mage::helper('customerpreference')->__('Budget To'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'budget_to',
      ));

      /*
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('customerpreference')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('customerpreference')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('customerpreference')->__('Disabled'),
              ),
          ),
      ));

      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('customerpreference')->__('Content'),
          'title'     => Mage::helper('customerpreference')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));*/

      if ( Mage::getSingleton('adminhtml/session')->getCustomerpreferenceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCustomerpreferenceData());
          Mage::getSingleton('adminhtml/session')->setCustomerpreferenceData(null);
      } elseif ( Mage::registry('customerpreference_data') ) {
          $form->setValues(Mage::registry('customerpreference_data')->getData());
      }
      return parent::_prepareForm();
  }
}
