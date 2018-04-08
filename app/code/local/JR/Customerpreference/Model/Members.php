<?php

class JR_Customerpreference_Model_Members extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('customerpreference/members');
    }
}
