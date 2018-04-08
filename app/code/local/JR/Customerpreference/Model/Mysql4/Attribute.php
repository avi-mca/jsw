<?php

class JR_Customerpreference_Model_Mysql4_Attribute extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        // Note that the preference_attr_id refers to the key field in your database table.
        $this->_init('customerpreference/attribute', 'preference_attr_id');
    }
}
