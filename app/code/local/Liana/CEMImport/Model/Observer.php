<?php
class Liana_CEMImport_Model_Observer
{
    public function exportOrders(){
        $model = new Liana_CEMImport_Model_Order();
        $orderList = $model->getOrderList();
        try{
            $api_user       = Mage::getStoreConfig('cemimport/settings/api_user');
            $api_key        = Mage::getStoreConfig('cemimport/settings/api_key');
            $api_url        = Mage::getStoreConfig('cemimport/settings/api_url');
            $api_version    = Mage::getStoreConfig('cemimport/settings/api_version');

            $restClient = new Liana_CEMImport_Model_RestClient(
                $api_user, $api_key, $api_url, $api_version
            );

            if(!empty($orderList)){
                $restClient->call('import', $orderList);
            }
        } catch( Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }
}