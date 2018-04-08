<?php
class JR_Customerpreference_Block_Adminhtml_Customerpreference_Edit_Tab_Members extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('customer_members_grid');
        $this->setDefaultSort('created_at', 'asc');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('customerpreference/members')->getCollection()
            ->addFieldToSelect('members_id')
            ->addFieldToSelect('name')
            ->addFieldToSelect('relationship')
            ->addFieldToSelect('age')
            ->addFieldToFilter('preference_id', Mage::registry('customerpreference_data')->getId());

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('members_id', array(
            'header'    => Mage::helper('customer')->__('Members Id'),
            'width'     => '100',
            'index'     => 'members_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('customer')->__('Fullname'),
            'index'     => 'name',
        ));

        $this->addColumn('relationship', array(
            'header'    => Mage::helper('customer')->__('Relationship'),
            'index'     => 'relationship',
        ));

        $this->addColumn('age', array(
            'header'    => Mage::helper('customer')->__('Age'),
            'index'     => 'age',
        ));


        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/members', array('_current' => true));
    }

}
