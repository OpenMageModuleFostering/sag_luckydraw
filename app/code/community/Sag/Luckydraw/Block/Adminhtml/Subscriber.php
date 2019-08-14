<?php
class Sag_Luckydraw_Block_Adminhtml_Subscriber extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_subscriber';
    $this->_blockGroup = 'luckydraw';
    $this->_headerText = Mage::helper('luckydraw')->__('Subscriber Manager');
    parent::__construct();
	$this->_removeButton('add');
  }
  
  
}