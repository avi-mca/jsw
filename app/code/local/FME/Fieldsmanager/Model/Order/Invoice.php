<?php
/*////////////////////////////////////////////////////////////////////////////////
 \\\\\\\\\\\\\\\\\\\\\\\\\      FME Fieldsmanager extension   \\\\\\\\\\\\\\\\\\\\
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

class FME_Fieldsmanager_Model_Order_Invoice extends Mage_Sales_Model_Order_Invoice
{
    
    /**
     * Send email with invoice data
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Invoice
     */
    public function sendEmail($notifyCustomer = true, $comment = '')
    {
        $order = $this->getOrder();
        $storeId = $order->getStore()->getId();

        if (!Mage::helper('sales')->canSendNewInvoiceEmail($storeId)) {
            return $this;
        }
        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $storeId);
        // Check if at least one recepient is found
        if (!$notifyCustomer && !$copyTo) {
            return $this;
        }

        // Start store emulation process
        $appEmulation = Mage::getSingleton('core/app_emulation');
        $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($storeId);

        try {
            // Retrieve specified view block from appropriate design package (depends on emulated store)
            $paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
                ->setIsSecureMode(true);
            $paymentBlock->getMethod()->setStore($storeId);
            $paymentBlockHtml = $paymentBlock->toHtml();
        } catch (Exception $exception) {
            // Stop store emulation process
            $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            throw $exception;
        }

        // Stop store emulation process
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

        // Retrieve corresponding email template id and customer name
        if ($order->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $storeId);
            $customerName = $order->getCustomerName();
        }

        $mailer = Mage::getModel('core/email_template_mailer');
        if ($notifyCustomer) {
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($order->getCustomerEmail(), $customerName);
            if ($copyTo && $copyMethod == 'bcc') {
                // Add bcc to customer email
                foreach ($copyTo as $email) {
                    $emailInfo->addBcc($email);
                }
            }
            $mailer->addEmailInfo($emailInfo);
        }

        // Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
        if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }
        $fieldmanagerObject = new Varien_Object();
        if($additionalData = Mage::getModel('fieldsmanager/fieldsmanager')->GetFMData($order->getEntityId(),'orders',1)){
            $fieldmanagerObject->setData($additionalData);
        }
        $html ='';
        if(count($fieldmanagerObject->getData())){
            $html = '<table border="0">';
            $additionalData=Mage::getModel('fieldsmanager/fieldsmanager')->GetFMData($this->getEntityId(), 'orders' , false);
            foreach ($additionalData as $info): 
                   $html .= '<tr><td style="font-size:12px; line-height:10px; text-align: left; padding: 7px 9px 9px 9px;" width="165"><label style="font-weight:bold;">'. $info['label'] . '</label></td>';
                   $html .= '<td style="font-size:12px; line-height:10px; text-align: left; padding: 7px 9px 9px 9px;">'. $info['value'] .'</td></tr>';
            endforeach; 
            $html .= '</table>';
    
        }
        $fieldmanagerObject->setData('html',$html);

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'        => $order,
                'invoice'      => $this,
                'comment'      => $comment,
                'billing'      => $order->getBillingAddress(),
                'payment_html' => $paymentBlockHtml,
                'fieldsmanager' => $fieldmanagerObject
            )
        );
        $mailer->send();
        $this->setEmailSent(true);
        $this->_getResource()->saveAttribute($this, 'email_sent');

        return $this;
    }

    /**
     * Send email with invoice update information
     *
     * @param boolean $notifyCustomer
     * @param string $comment
     * @return Mage_Sales_Model_Order_Invoice
     */
    public function sendUpdateEmail($notifyCustomer = true, $comment = '')
    {
        $order = $this->getOrder();
        $storeId = $order->getStore()->getId();

        if (!Mage::helper('sales')->canSendInvoiceCommentEmail($storeId)) {
            return $this;
        }
        // Get the destination email addresses to send copies to
        $copyTo = $this->_getEmails(self::XML_PATH_UPDATE_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_COPY_METHOD, $storeId);
        // Check if at least one recepient is found
        if (!$notifyCustomer && !$copyTo) {
            return $this;
        }

        // Retrieve corresponding email template id and customer name
        if ($order->getCustomerIsGuest()) {
            $templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_GUEST_TEMPLATE, $storeId);
            $customerName = $order->getBillingAddress()->getName();
        } else {
            $templateId = Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_TEMPLATE, $storeId);
            $customerName = $order->getCustomerName();
        }

        $mailer = Mage::getModel('core/email_template_mailer');
        if ($notifyCustomer) {
            $emailInfo = Mage::getModel('core/email_info');
            $emailInfo->addTo($order->getCustomerEmail(), $customerName);
            if ($copyTo && $copyMethod == 'bcc') {
                // Add bcc to customer email
                foreach ($copyTo as $email) {
                    $emailInfo->addBcc($email);
                }
            }
            $mailer->addEmailInfo($emailInfo);
        }

        // Email copies are sent as separated emails if their copy method is 'copy' or a customer should not be notified
        if ($copyTo && ($copyMethod == 'copy' || !$notifyCustomer)) {
            foreach ($copyTo as $email) {
                $emailInfo = Mage::getModel('core/email_info');
                $emailInfo->addTo($email);
                $mailer->addEmailInfo($emailInfo);
            }
        }
        $fieldmanagerObject = new Varien_Object();
        
        if($additionalData = Mage::getModel('fieldsmanager/fieldsmanager')->GetFMData($order->getEntityId(),'orders',1)){
            $fieldmanagerObject->setData($additionalData);
        }
        $html ='';
        if(count($fieldmanagerObject->getData())){
            $html = '<table border="0">';
            $additionalData=Mage::getModel('fieldsmanager/fieldsmanager')->GetFMData($this->getEntityId(), 'orders' , false);
            foreach ($additionalData as $info): 
                   $html .= '<tr><td style="font-size:12px; line-height:10px; text-align: left; padding: 7px 9px 9px 9px;" width="165"><label style="font-weight:bold;">'. $info['label'] . '</label></td>';
                   $html .= '<td style="font-size:12px; line-height:10px; text-align: left; padding: 7px 9px 9px 9px;">'. $info['value'] .'</td></tr>';
            endforeach; 
            $html .= '</table>';
    
        }
        $fieldmanagerObject->setData('html',$html);

        // Set all required params and send emails
        $mailer->setSender(Mage::getStoreConfig(self::XML_PATH_UPDATE_EMAIL_IDENTITY, $storeId));
        $mailer->setStoreId($storeId);
        $mailer->setTemplateId($templateId);
        $mailer->setTemplateParams(array(
                'order'        => $order,
                'invoice'      => $this,
                'comment'      => $comment,
                'billing'      => $order->getBillingAddress(),
                'fieldsmanager' => $fieldmanagerObject
            )
        );
        $mailer->send();

        return $this;
    }


 
}
