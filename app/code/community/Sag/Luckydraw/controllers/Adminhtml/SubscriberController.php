<?php

class Sag_Luckydraw_Adminhtml_SubscriberController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('luckydraw/subscribers')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Subscriber Manager'), Mage::helper('adminhtml')->__('Subscriber Manager'));
			
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	
	

	public function newAction() {
		$this->_forward('edit');
	}
 
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('luckydraw/subscriber');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Subscriber was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $subscriberIds = $this->getRequest()->getParam('subscriber');
        if(!is_array($subscriberIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Subscriber(s)'));
        } else {
            try {
                foreach ($subscriberIds as $subscriberId) {
                    $subscriber = Mage::getModel('luckydraw/subscriber')->load($subscriberId);
                    $subscriber->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($subscriberIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	

	
}