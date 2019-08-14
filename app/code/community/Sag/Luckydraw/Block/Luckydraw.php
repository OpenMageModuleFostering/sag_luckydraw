<?php
class Sag_Luckydraw_Block_Luckydraw extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getLuckydraw()     
    { 
        if (!$this->hasData('luckydraw')) {
            $this->setData('luckydraw', Mage::getModel('luckydraw/luckydraw')->getCollection()->addFilter('status', '1'));
        }
        return $this->getData('luckydraw');
    }
	
	
	public function getFormActionUrl()
    {
        return $this->getUrl('luckydraw', array('_secure' => true));
    }
	
	
	public function postAction()
    {
		//echo $_POST['email'].'<br>';
		//echo $_POST['luckydraw_id']; 
		
		$write = Mage::getSingleton('core/resource')->getConnection('core_write');

			// now $write is an instance of Zend_Db_Adapter_Abstract
			$readresult=$write->query("SELECT *
			FROM subscriber
			WHERE
			subscriber_email='".$_POST['email']."' and luckydraw_id='".$_POST['luckydraw_id']."'");
			
			
			$row = $readresult->fetch();
				if($row['subscriber_id']!=''){
					Mage::getSingleton('core/session')->addSuccess('This Email Id is already exists.');
				}else{
					$write->query("INSERT INTO subscriber (subscriber_email, luckydraw_id, created_time) VALUES ('".$_POST['email']."', '".$_POST['luckydraw_id']."', now())");
					Mage::getSingleton('core/session')->addSuccess('Email Id is saved.');
				}
			header('location:../luckydraw');exit;
	}
	
	
	
	
	/**
	 * Resize Image proportionally and return the resized image url
	 *
	 * @param string $imageName         name of the image file
	 * @param integer|null $width       resize width
	 * @param integer|null $height      resize height
	 * @param string|null $imagePath    directory path of the image present inside media directory
	 * @return string               full url path of the image
	 */
	public function resizeImage($imageName, $width=NULL, $height=NULL, $imagePath=NULL)
	{      
		$imagePath = str_replace("/", DS, $imagePath);
		$imagePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $imageName;
		 
		if($width == NULL && $height == NULL) {
			$width = 100;
			$height = 100;
		}
		$resizePath = $width . 'x' . $height;
		$resizePathFull = Mage::getBaseDir('media') . DS . $imagePath . DS . $resizePath . DS . $imageName;
				 
		if (file_exists($imagePathFull) && !file_exists($resizePathFull)) {
			$imageObj = new Varien_Image($imagePathFull);
			$imageObj->constrainOnly(TRUE);
			$imageObj->keepAspectRatio(TRUE);
			$imageObj->resize($width,$height);
			$imageObj->save($resizePathFull);
		}
				 
		$imagePath=str_replace(DS, "/", $imagePath);
		$img = Mage::getBaseUrl("media") . $imagePath . "/" . $resizePath . "/" . $imageName;
		return str_replace(DS, "/", $img);
	}

}