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
                      $attrModel->setData('values', implode(",",$values));
                      $attrModel->save();
                  }
              }
              $session->getCustomer()->setPreference(1)->save();
              $session->addSuccess(Mage::helper('customerpreference')->__('Thank you for submitting your preferences.'));
           } catch (Exception $e) {
              $session->addError($e->getMessage());
           }
        }
        $this->_redirectReferer();
        return;
    }
}
