<?php

class Sag_Luckydraw_Block_Adminhtml_Luckydraw_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('luckydraw_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('luckydraw')->__('Luckydraw Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('luckydraw')->__('Luckydraw Information'),
          'title'     => Mage::helper('luckydraw')->__('Luckydraw Information'),
          'content'   => $this->getLayout()->createBlock('luckydraw/adminhtml_luckydraw_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}