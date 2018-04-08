<?php

class JR_Customerpreference_Model_Customerpreference extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customerpreference/customerpreference');
    }
}