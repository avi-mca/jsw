<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/Block/Adminhtml/History/Edit/Form.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ aoQUjhmopCaTaapr('c6dd1017cabe8ef363c1a015c7bc8506'); ?><?php
class AdjustWare_Cartalert_Block_Adminhtml_History_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
          'id' => 'edit_form',
          'action' => '',
          'method' => 'post'));

      $form->setUseContainer(true);
      $this->setForm($form);
      $hlp = Mage::helper('adjcartalert');

      $fldInfo = $form->addFieldset('adjcartalert_info', array('legend'=> $hlp->__('Alert Variables')));
      
      $fldInfo->addField('customer_email', 'text', array(
          'label'     => $hlp->__('Customer E-mail'),
          'name'      => 'customer_email',
      ));
      $fldInfo->addField('customer_name', 'text', array(
          'label'     => $hlp->__('Customer Name'),
          'name'      => 'customer_name',
      ));
      
      $fldInfo->addField('txt', 'textarea', array(
          'label'     => $hlp->__('Message'),
          'name'      => 'txt',
          'style'     => 'width:35em;height:15em;',
      ));

      if ( Mage::registry('history_data') ) {
          $form->setValues(Mage::registry('history_data')->getData());
      }
      
      return parent::_prepareForm();
  }
} } 