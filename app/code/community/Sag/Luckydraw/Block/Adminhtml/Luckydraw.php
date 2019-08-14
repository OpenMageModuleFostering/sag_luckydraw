<?php
class Sag_Luckydraw_Block_Adminhtml_Luckydraw extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_luckydraw';
    $this->_blockGroup = 'luckydraw';
    $this->_headerText = Mage::helper('luckydraw')->__('Luckydraw Manager');
    $this->_addButtonLabel = Mage::helper('luckydraw')->__('Add Luckydraw');
    parent::__construct();
  }
  
  
}