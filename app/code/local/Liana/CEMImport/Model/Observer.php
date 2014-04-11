<?php
class Liana_CEMImport_Model_Observer
{

    protected static $_instance;
    private $_restClient;

    public function __construct(){
        $api_user       = Mage::getStoreConfig('cemimport/settings/api_user');
        $api_key        = Mage::getStoreConfig('cemimport/settings/api_key');
        $api_url        = Mage::getStoreConfig('cemimport/settings/api_url');
        $api_version    = Mage::getStoreConfig('cemimport/settings/api_version');
        
        $api_url = trim($api_url);
        $api_url = rtrim($api_url,"/");#remove slash at the end of url
        
        $this->_restClient = new Liana_CEMImport_Model_RestClient(
            $api_user, $api_key, $api_url, $api_version
        );
    }
    public static function getInstance(){
        if(is_null(self::$_instance)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function getRestClient(){
        return $this->_restClient;
    }

    public function exportOrders(){
        $model = new Liana_CEMImport_Model_Order();
        $orderList = $model->getOrderList();
        try{
            $restClient = Liana_CEMImport_Model_Observer::getInstance()->getRestClient();

            if(!empty($orderList)){
                $restClient->call('import', $orderList);
            }
        } catch( Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }

    public function exportCustomers(){
        $model = new Liana_CEMImport_Model_Customer();
        $customerList = $model->getCustomerList();
        try{
            $restClient = Liana_CEMImport_Model_Observer::getInstance()->getRestClient();
            if(!empty($customerList)){
                $restClient->call('import', $customerList);
            }
        } catch( Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }
}
