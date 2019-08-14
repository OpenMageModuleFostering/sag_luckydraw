<?php

class Sag_Luckydraw_Model_Mysql4_Luckydraw extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the gallery_id refers to the key field in your database table.
        $this->_init('luckydraw/luckydraw', 'luckydraw_id');
    }
}