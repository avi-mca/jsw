<?php

class JR_Customerpreference_Block_Adminhtml_Customerpreference_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('customerpreferenceGrid');
      $this->setDefaultSort('preference_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('customerpreference/customerpreference')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('preference_id', array(
          'header'    => Mage::helper('customerpreference')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'preference_id',
      ));

      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('customerpreference')->__('Customer Id'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));

      $this->addColumn('fullname', array(
          'header'    => Mage::helper('customerpreference')->__('Fullname'),
          'align'     =>'left',
          'index'     => 'fullname',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('customerpreference')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));


      $this->addColumn('status', array(
          'header'    => Mage::helper('customerpreference')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));*/

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customerpreference')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customerpreference')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));

		$this->addExportType('*/*/exportCsv', Mage::helper('customerpreference')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('customerpreference')->__('XML'));

      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('preference_id');
        $this->getMassactionBlock()->setFormFieldName('customerpreference');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customerpreference')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customerpreference')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('customerpreference/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('customerpreference')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('customerpreference')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
