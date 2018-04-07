<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/Helper/Data.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ aoQUjhmopCaTaapr('8c786adb2e8f8f91b3f6e0785fdeea80'); ?><?php

class AdjustWare_Cartalert_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getGroupArray()
    {
        $db = Mage::getSingleton('core/resource')->getConnection('core_read');
        $select = $db->select()->from(Mage::getSingleton('core/resource')->getTableName('customer/customer_group'), array('customer_group_id', 'customer_group_code'));
        $groupIds = array();
        foreach($db->fetchAll($select) as $group)
        {
            $groupIds[$group['customer_group_id']] = $group['customer_group_code'];
        }
        return $groupIds;
    }
} } 