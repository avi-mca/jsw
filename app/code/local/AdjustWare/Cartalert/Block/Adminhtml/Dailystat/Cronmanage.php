<?php
/**
 * Product:     Abandoned Carts Alerts Pro for 1.3.x-1.7.0.0 - 25/05/13
 * Package:     AdjustWare_Cartalert_3.1.2_0.2.3_596877
 * Purchase ID: hEiWUQsQRryGdapAGSPJZvOsCja6Q1R7rm8Ev5yFc8
 * Generated:   2013-06-11 07:09:14
 * File path:   app/code/local/AdjustWare/Cartalert/Block/Adminhtml/Dailystat/Cronmanage.php
 * Copyright:   (c) 2013 AITOC, Inc.
 */
?>
<?php if(Aitoc_Aitsys_Abstract_Service::initSource(__FILE__,'AdjustWare_Cartalert')){ ZiRIeqyiohZUZZoa('b0cba63898548ce8f77c9340235f3683'); ?><?php 
class AdjustWare_Cartalert_Block_Adminhtml_Dailystat_Cronmanage extends Mage_Adminhtml_Block_Template
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('adjcartalert/cronmanage.phtml'); 
    }
    
    public function getIsBusy()
    {   
        return Mage::getModel('adjcartalert/cronstat')->isBusy();
    }
   
} } 