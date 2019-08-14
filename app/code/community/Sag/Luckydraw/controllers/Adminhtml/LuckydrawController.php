<?php

class Sag_Luckydraw_Adminhtml_LuckydrawController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('luckydraw/Luckydraws')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Luckydraw Manager'), Mage::helper('adminhtml')->__('Luckydraw Manager'));
			
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('luckydraw/luckydraw')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('luckydraw_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('luckydraw/luckydraws');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Luckydraw Manager'), Mage::helper('adminhtml')->__('Luckydraw Manager'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('luckydraw/adminhtml_luckydraw_edit'))
				->_addLeft($this->getLayout()->createBlock('luckydraw/adminhtml_luckydraw_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('luckydraw')->__('Luckydraw does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'luckydraw' . DS. 'luckydraw' . DS;
					$uploader->save($path, str_replace(' ', '_',$_FILES['filename']['name']) );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = 'luckydraw' . DS. 'luckydraw' . DS. str_replace(' ', '_',$_FILES['filename']['name']);
			}else {
				unset($data['filename']);  // Unset filename part when image upload field is empty       
			}

	  			
	  			
			$model = Mage::getModel('luckydraw/luckydraw');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('luckydraw')->__('Luckydraw was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('luckydraw')->__('Unable to find Luckydraw to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('luckydraw/luckydraw');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Luckydraw was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $luckydrawIds = $this->getRequest()->getParam('luckydraw');
        if(!is_array($luckydrawIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Luckydraw(s)'));
        } else {
            try {
                foreach ($luckydrawIds as $luckydrawId) {
                    $luckydraw = Mage::getModel('luckydraw/luckydraw')->load($luckydrawId);
                    $luckydraw->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($luckydrawIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $luckydrawIds = $this->getRequest()->getParam('luckydraw');
        if(!is_array($luckydrawIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Luckydraw(s)'));
        } else {
            try {
                foreach ($luckydrawIds as $luckydrawId) {
                    $luckydraw = Mage::getSingleton('luckydraw/luckydraw')
                        ->load($luckydrawId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($luckydrawIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	
}