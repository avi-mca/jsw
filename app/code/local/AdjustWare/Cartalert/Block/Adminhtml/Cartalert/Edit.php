<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/Block/Adminhtml/Cartalert/Edit.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ jhUCgorhwpjcjjwD('013670464b93953794539a7b013158e6'); ?><?php

class AdjustWare_Cartalert_Block_Adminhtml_Cartalert_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id'; // ?
        $this->_blockGroup = 'adjcartalert';
        $this->_controller = 'adminhtml_cartalert';

        $this->_removeButton('reset');
		
        $this->_addButton('send', array(
            'label'     => Mage::helper('adjcartalert')->__('Save and Send Out'),
            'onclick'   => 'sendAndDelete()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function sendAndDelete(){
                $('edit_form').action += 'send/edit';
                editForm.submit();
            }
        ";
    }

    public function getHeaderText()
    {
            return Mage::helper('adjcartalert')->__('Abandoned Cart Alert');
    }
} } 