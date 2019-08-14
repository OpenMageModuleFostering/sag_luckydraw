<?php

class Sag_Luckydraw_Block_Adminhtml_Subscriber_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('subscriberGrid');
      $this->setDefaultSort('subscriber_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('luckydraw/subscriber')->getCollection();
	  $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('subscriber_id', array(
          'header'    => Mage::helper('luckydraw')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'subscriber_id',
      ));

      $this->addColumn('subscriber_email', array(
          'header'    => Mage::helper('luckydraw')->__('Email'),
          'align'     =>'left',
          'index'     => 'subscriber_email',
      ));

	 

	  
	  ///////////////////////////////////Luckydraw////////////////////////////////////
	  $_draw = Mage::getModel('luckydraw/luckydraw')->getCollection(); 
	  foreach($_draw as $item)
	  { 
			if($item->getParent == NULL){
				$_lukydrawIds[$item->getLuckydrawId()] = $item->getTitle();
			}
	  }
	  $this->addColumn('luckydraw_id', array(
          'header'    => Mage::helper('luckydraw')->__('Luckydraw'),
          'align'     => 'left',
          'width'     => '300px',
          'index'     => 'luckydraw_id',
          'type'      => 'options',
          'options'   => $_lukydrawIds,
      ));
	  ///////////////////////////////////Luckydraw////////////////////////////////////
	  
	  
		
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('subscriber_id');
        $this->getMassactionBlock()->setFormFieldName('subscriber');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('luckydraw')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('luckydraw')->__('Are you sure?')
        ));

       
        return $this;
    }
}