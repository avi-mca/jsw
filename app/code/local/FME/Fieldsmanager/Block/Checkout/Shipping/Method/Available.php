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

class FME_Fieldsmanager_Block_Checkout_Shipping_Method_Available extends Mage_Checkout_Block_Onepage_Shipping_Method_Available
{
    protected function _toHtml(){	
 if(Mage::helper('fieldsmanager')->getStoredDatafor('enable') && !Mage::getStoreConfig('quickcheckout/general/active')){
	    $this->setTemplate("fieldsmanager/checkout/onepage/shipping_method/available.phtml");
	
	}
       return parent::_toHtml();
    }
   
    public function getfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('4', $locate , 'fm_fields', 'catalog' , '<li class="d_2 fields">' , '</li>');
	    return $collection;
	}
    }
}