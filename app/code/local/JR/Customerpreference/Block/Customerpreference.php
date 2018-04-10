<?php
class JR_Customerpreference_Block_Customerpreference extends Mage_Core_Block_Template
{
		public function _prepareLayout()
		{
			return parent::_prepareLayout();
		}

		public function getCustomerpreference()
		{
		  if (!$this->hasData('customerpreference')) {
		      $this->setData('customerpreference', Mage::registry('customerpreference'));
		  }
		  return $this->getData('customerpreference');

		}
		
}
