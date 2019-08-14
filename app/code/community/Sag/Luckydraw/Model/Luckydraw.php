<?php

class Sag_Luckydraw_Model_Luckydraw extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('luckydraw/luckydraw');
    }
	
	public function getCollection() {
        return Mage::getResourceModel('luckydraw/luckydraw_collection');
    }
}