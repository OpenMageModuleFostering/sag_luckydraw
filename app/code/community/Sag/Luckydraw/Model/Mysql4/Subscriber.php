<?php

class Sag_Luckydraw_Model_Mysql4_Subscriber extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        // Note that the subscriber_id refers to the key field in your database table.
        $this->_init('luckydraw/subscriber', 'subscriber_id');
    }
}