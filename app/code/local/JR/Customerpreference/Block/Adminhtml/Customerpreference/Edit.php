<?php

class JR_Customerpreference_Block_Adminhtml_Customerpreference_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'customerpreference';
        $this->_controller = 'adminhtml_customerpreference';

        $this->_updateButton('save', 'label', Mage::helper('customerpreference')->__('Save Preference'));
        $this->_updateButton('delete', 'label', Mage::helper('customerpreference')->__('Delete Preference'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('customerpreference_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'customerpreference_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'customerpreference_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('customerpreference_data') && Mage::registry('customerpreference_data')->getId() ) {
            return Mage::helper('customerpreference')->__("Edit Preference");
        } else {
            return Mage::helper('customerpreference')->__('Add Preference');
        }
    }
}
