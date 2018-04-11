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
 \\* @copyright  Copyright 2010 © free-magentoextensions.com All right reserved\\\
 /////////////////////////////////////////////////////////////////////////////////
 */

class FME_Fieldsmanager_Helper_Data extends Mage_Core_Helper_Abstract
{
    function getEavAttribute($model , $r = false , $i= null)
    {
        $model->getSelect()->join(
            array('additional_table' => $this->getTable('catalog')),
            'additional_table.attribute_id=main_table.attribute_id'
        );
        if($r){
            return $model;
        }
        if($i){
            $model->getSelect()->where('main_table.attribute_id = ' . $i);
            $d= $model->getData();
           return $d[0];
        }
    }
    function getTable($StepType)
    {
        $eavattrib = Mage::getResourceModel('eav/entity_attribute');
        switch($StepType){
            case 'catalog':
                return  $eavattrib->getTable('catalog/eav_attribute');
                break;
            case 'customer':
                  return  $eavattrib->getTable('customer/eav_attribute');
                break;
            default:
            return false;
        }
       
    }
    function getFMTable($table)
    {
        if($table)return Mage::getSingleton('core/resource')->getTableName('fieldsmanager/' . $table);
       return;
    }
    function getSource($data)
    {
        if (in_array($data['frontend_input'], array('multiselect', 'select', 'radio', 'checkbox')))
            {
                $data['source_model']='eav/entity_attribute_source_table';
            }
            if ($data['frontend_input']==='date' || $data['frontend_input']==='checkbox'  || $data['frontend_input']==='message')
            {
                $data['backend_type']='varchar';   
            }
            return $data;
    }
    function setDefault($data, $model)
    {
        if (in_array($data['frontend_input'], array('multiselect', 'select', 'radio', 'checkbox')))
        {
            if (!empty($data['default']))
            {
                if (is_array($data['default']))
		{
		    $DefaultOptionValue = implode(',', $data['default']);
                    return $DefaultOptionValue;
		}
                return $data['default'];
            }
            else 
            {
                return;
            }
        }
        else 
        {
            if (is_array($model->getDefaultValue()))
            {
                $DefaultOptionValue = implode(',', $model->getDefaultValue());
                return $DefaultOptionValue;
            }
            return $model->getDefaultValue();
        }

       
    }
    function getheading(){
	if($head= $this->getStoredDatafor('heading')){
	    return $head;
	}
	return 'Additional Information';
    }
   function getStoredDatafor($data){
	return Mage::getStoreConfig('fieldsmanager/general/' . $data);
    }
    public function getBillingfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('2', $locate , 'fm_fields', 'catalog' , '<li id="fme_billing_'.$locate.'" class="d_2 fields">' , '</li>');
	    return $collection;
	}
    }
    public function getShippingfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	   $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('3', $locate , 'fm_fields', 'catalog' , '<li id="fme_shipping_'.$locate.'" class="d_2 fields">' , '</li>');
	    return $collection;
	}
    }
    public function getShippingMethodfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('4', $locate , 'fm_fields', 'catalog' , '<li class="d_2 fields">' , '</li>');
	    return $collection;
	}
    }
    public function getPaymentfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('5', $locate , 'fm_fields', 'catalog' , '<dt id="fme_payment_methods_'.$locate.'">' , '</dt>');
	    return $collection;
	}
    }
    public function getReviewfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('6', $locate , 'fm_fields', 'catalog' , '<div class="d_2 review_fields" style="padding:5px 30px;border-color: #D9DDE3;border-style: solid;border-width: 1px;">' , '</div>');
	    return $collection;
	}
    }
    public function getRegisterationfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('2', $locate , 'fme_register', 'catalog' , '<li id="fme_billing_'.$locate.'" class="fields">' , '</li>');
	    return $collection;
	}
    }
     public function getAccountfieldshtml($locate)
    {
	if(Mage::helper('fieldsmanager')->getStoredDatafor('enable')){
	    $collection=Mage::getModel('fieldsmanager/fieldsmanager')->getAllFieldsHtml('2', $locate , 'fme_account', 'catalog' , '<li id="fme_billing_'.$locate.'" class="fields">' , '</li>');
	    return $collection;
	}
    }
}

 