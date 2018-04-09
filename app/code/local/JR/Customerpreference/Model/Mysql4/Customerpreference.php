<?php

class JR_Customerpreference_Model_Mysql4_Customerpreference extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the preference_id refers to the key field in your database table.
        $this->_init('customerpreference/customerpreference', 'preference_id');
    }
}
