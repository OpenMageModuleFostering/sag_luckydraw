<?php

class Sag_Luckydraw_Model_Mysql4_Luckydraw_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('luckydraw/luckydraw');
    }
}