<?php

class Sag_Luckydraw_Block_Adminhtml_Luckydraw_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('luckydraw_form', array('legend'=>Mage::helper('luckydraw')->__('Luckydraw Information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('luckydraw')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
	  
 
      $fieldset->addField('filename', 'image', array(
          'label'     => Mage::helper('luckydraw')->__('Image'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('luckydraw')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('luckydraw')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('luckydraw')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('luckydraw')->__('Content'),
          'title'     => Mage::helper('luckydraw')->__('Content'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getLuckydrawData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLuckydrawData());
          Mage::getSingleton('adminhtml/session')->setLuckydrawData(null);
      } elseif ( Mage::registry('luckydraw_data') ) {
          $form->setValues(Mage::registry('luckydraw_data')->getData());
      }
      return parent::_prepareForm();
  }
}