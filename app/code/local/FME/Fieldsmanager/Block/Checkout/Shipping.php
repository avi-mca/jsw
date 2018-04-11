<?php
/*////////////////////////////////////////////////////////////////////////////////
 \\\\\\\\\\\\\\\\\\\\\\\\\  FME Fieldsmanager extension  \\\\\\\\\\\\\\\\\\\\\\\\\
 /////////////////////////////////////////////////////////////////////////////////
 \\\\\\\\\\\\\\\\\\\\\\\\\ NOTICE OF LICENSE\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 ///////                                                                   ///////
 \\\\\\\ This source file is subject to the Open Software License (OSL 3.0)\\\\\\\
 ///////   that is bundled with this package in the file LICENSE.txt.      ///////
 \\\\\\\   It is also available through the world-wide-web at this URL:    \\\\\\\
 ///////          http://opensource.org/licenses/osl-3.0.php               ///////
 \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
 ///////                      * @category   FME                            ///////
 \\\\\\\                      * @package    FME_Fieldsmanager              \\\\\\\
 ///////    * @author     Malik Tahir Mehmood <support@fmeextensions.com>   ///////
 \\\\\\\                                                                   \\\\\\\
 /////////////////////////////////////////////////////////////////////////////////
 \\* @copyright  Copyright 2010 � free-magentoextensions.com All right reserved\\\
 /////////////////////////////////////////////////////////////////////////////////
 */

class FME_Fieldsmanager_Block_Checkout_Shipping extends Mage_Checkout_Block_Onepage_Shipping
{
    protected function _toHtml(){
	 if(Mage::helper('fieldsmanager')->getStoredDatafor('enable') && !Mage::getStoreConfig('quickcheckout/general/active')){
	   $version = Mage::getVersion();
	if(version_compare($version,'1.7.0.0','<')){
	   $this->setTemplate("fieldsmanager/checkout/onepage/shipping.phtml"); 
	}else{
	    $this->setTemplate("fieldsmanager/checkout/onepage/1700/shipping.phtml");
	}
        
	}
	
	return parent::_toHtml();
    }
   
    public function getfieldshtml($locate)
    { if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	   $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('3', $locate , 'fm_fields', 'catalog' , '<li id="fme_shipping_'.$locate.'" class="d_2 fields">' , '</li>');
    
        return $collection;
       
	}
        
    }
}
