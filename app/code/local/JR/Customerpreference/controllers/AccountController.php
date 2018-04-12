<?php
require_once Mage::getModuleDir('controllers', 'Mage_Customer') . DS . 'AccountController.php';
class JR_Customerpreference_AccountController extends Mage_Customer_AccountController
{
    public function preferenceAction()
    {
    		$this->loadLayout();
        $this->_initLayoutMessages('customer/session');
    		$this->renderLayout();
    }

    public function preferencePostAction()
    {
        if (!$this->_validateFormKey()) {
            $this->_redirect('*/preference');
            return;
        }

        if (!$this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
        $session = $this->_getSession();

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            //echo "<pre>"; print_r($data); die;
            $preferenceData = array(
                                'entity_id' => $session->getCustomer()->getId(),
                                'fullname'  => $data['fullname'],
                                'budget_from' => $data['budget_from'],
                                'budget_to'  => $data['budget_to'],
                                'status'      => 1
                              );

            $preferenceModel = Mage::getModel('customerpreference/customerpreference');
      			$preferenceModel->setData($preferenceData);
            try {
      				if ($preferenceModel->getCreatedTime == NULL || $preferenceModel->getUpdateTime() == NULL) {
      					$preferenceModel->setCreatedTime(now())
      						->setUpdateTime(now());
      				} else {
      					$preferenceModel->setUpdateTime(now());
      				}

      				$preferenceModel->save();
              if($preference_id = $preferenceModel->getId()){
                  foreach ($data['members'] as $_member) {
                      $memberModel = Mage::getModel('customerpreference/members');
                      $memberModel->setData('preference_id', $preference_id);
                      $memberModel->setData('name', $_member['name']);
                      $memberModel->setData('relationship', $_member['relationship']);
                      $memberModel->setData('age', $_member['age']);
                      $memberModel->save();
                  }

                  foreach ($data['attribute'] as $attributeCode => $values) {
                      $attributeId = Mage::getResourceModel('eav/entity_attribute')
    ->getIdByCode('catalog_product', $attributeCode);
                      $attrModel = Mage::getModel('customerpreference/attribute');
                      $attrModel->setData('preference_id', $preference_id);
                      $attrModel->setData('attribute_id', $attributeId);
                      $attrModel->setData('attribute_code', $attributeCode);
                      $attrModel->setData('values', implode(",",$values));
                      $attrModel->save();
                  }
              }
              $session->getCustomer()->setPreference(1)->save();
              $session->addSuccess(Mage::helper('customerpreference')->__('Thank you for submitting your preferences.'));
              $this->sendJrTransactionalEmail($preference_id, $session->getCustomer());
           } catch (Exception $e) {
              $session->addError($e->getMessage());
           }
        }
        $this->_redirectReferer();
        return;
    }
    /**
     * Customer logout action
     */
    public function logoutAction()
    {
        $session = $this->_getSession();
        $session->logout()->renewSession();

        if (Mage::getStoreConfigFlag(Mage_Customer_Helper_Data::XML_PATH_CUSTOMER_STARTUP_REDIRECT_TO_DASHBOARD)) {
            $session->setBeforeAuthUrl(Mage::getBaseUrl());
        } else {
            $session->setBeforeAuthUrl($this->_getRefererUrl());
        }
        Mage::getSingleton('core/session')->setShownPopup(0);
        $this->_redirect('*/*/logoutSuccess');
    }

    public function sendJrTransactionalEmail($preference_id, $customer)
    {
        // set the Transactional Email Template's ID that you've created...
        $templateId = 1;

        // Set sender information
        $senderName = Mage::getStoreConfig('trans_email/ident_support/name');
        $senderEmail = Mage::getStoreConfig('trans_email/ident_support/email');
        $sender = array(
                    'name' => $senderName,
                    'email' => $senderEmail
                  );

        // Set recepient information
        $recepientEmail = $customer->getEmail();
        $recepientName = $customer->getName();

        // Get Store ID
        $storeId = Mage::app()->getStore()->getId();

        // creating products data
        $preferedAttributes = Mage::getModel('customerpreference/attribute')->getCollection()
                                      ->addFieldToFilter('preference_id', array('eq' => $preference_id));

        $visibility = array(
          Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
          Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG,
          Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH
        );
        $productCollection = Mage::getModel('catalog/product')->getCollection()
                                          ->addAttributeToSelect('*')
                                          ->addAttributeToFilter('visibility' , $visibility)
                                          ->addAttributeToFilter('status', '1');
        foreach ($preferedAttributes as $attr) {
            $productCollection->addAttributeToFilter($attr->getAttributeCode(), array('in' => explode(",",$attr->getValues())));
        }
        if(count($productCollection) > 0){
            $_productCollection = $productCollection;
        }else{
            $block = $this->getLayout()->createBlock('reports/product_viewed');
            $_productCollection = $block->getItemsCollection();
        }
        $_productCollection->getSelect()->limit(2);

        $html = '';
        foreach($_productCollection as $_product){
            $html .= '<table width="50%" border="0" cellspacing="0" cellpadding="0" align="center" style="float:left;">
              <tr>
                <td align="center"><img src="'.Mage::helper('catalog/image')->init($_product, 'small_image')->resize(250,130).'" alt="'.$_product->getName().'" /></td>
              </tr>
              <tr>
                <td>
                  <h4 style="text-align:center; font-size:18px;">'.$_product->getName().'</h4>
                    <h4 style="text-align:center;font-size:16px; color:#999"><span>'.Mage::helper('core')->currency($_product->getFinalPrice(), true, false).'</span></h4>
                </td>
              </tr>
              <tr>
                <td align="center" style="text-align:center"><a href="'.$_product->getProductUrl().'"><img src="'.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN).'"images/btn-view-details.png"  alt="View Details" /></a></td>
              </tr>
            </table>';
        }
        if(count($_productCollection) > 0){
          $html = '<tr>
            <td><h2 style="margin-bottom:40px;">Recomendations for you</h2></td>
          </tr>
          <tr>
            <td>
              '.$html.'
            </td>
          </tr>';
        }

        // Set variables that can be used in email template. To get this variable write like {{var customerEmail}} in transactional Email.
        $vars = array('name' => $customer->getName(), 'html' => $html);

        $translate  = Mage::getSingleton('core/translate');

        // Send Transactional Email
        Mage::getModel('core/email_template')
            ->sendTransactional($templateId, $sender, $recepientEmail, $recepientName, $vars, $storeId);

        $translate->setTranslateInline(true);
    }
}
