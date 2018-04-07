<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/Model/Mysql4/Quotestat/Collection.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ eqIhMiaqhoeCeehj('00e2096a0c1b902d00c3027ed8a139ae'); ?><?php

class AdjustWare_Cartalert_Model_Mysql4_Quotestat_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('adjcartalert/quotestat');
    }
    
    protected function _afterLoad()
    {
        parent::_afterLoad();
        $currency = Mage::app()->getStore()->getCurrentCurrencyCode();
        foreach ($this->_items as $item) {
            $item->setStatus('Just abandoned');
            if($item->getAlertNumber())
            {
                $item->setStatus('Reminded '.$item->getAlertNumber().' time(s)');
            }
            if($item->getRecoveryDate())
            {
                $item->setStatus('Recovered');
            }
            if($item->getOrderDate())
            {
                $item->setStatus('Ordered');
            }
            $item->setCurrency($currency);
        }
        return $this;
    }    
    
} } 