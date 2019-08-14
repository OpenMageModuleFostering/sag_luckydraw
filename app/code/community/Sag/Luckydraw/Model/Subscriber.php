<?php

class Sag_Luckydraw_Model_Subscriber extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('luckydraw/subscriber');
    }
	
	public function getCollection() {
        return Mage::getResourceModel('luckydraw/subscriber_collection');
    }
}