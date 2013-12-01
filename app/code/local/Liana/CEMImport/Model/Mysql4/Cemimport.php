<?php
class Liana_CEMImport_Model_Mysql4_CEMImport extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('cemimport/cemimport', 'cemimport_id');
    }
}
