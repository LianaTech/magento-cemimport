<?php
class Liana_CEMImport_Model_Observer
{

    protected static $_instance;
	private $_restClient;
	protected $cem_channel = null;

    public function __construct(){
        $api_user       = Mage::getStoreConfig('cemimport/settings/api_user');
        $api_key        = Mage::getStoreConfig('cemimport/settings/api_key');
        $api_url        = Mage::getStoreConfig('cemimport/settings/api_url');
		$api_version    = Mage::getStoreConfig('cemimport/settings/api_version');
		$api_realm		= Mage::getStoreConfig('cemimport/settings/api_realm');
		$this->cem_channel	= Mage::getStoreConfig('cemimport/settings/cem_channel');
        
        $api_url = trim($api_url);
        $api_url = rtrim($api_url,"/");#remove slash at the end of url
        
        $this->_restClient = new Liana_CEMImport_Model_RestClient(
            $api_user, $api_key, $api_url, $api_version, $api_realm
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
        $orderList = $model->getOrderList($this->cem_channel);
        try{
            $restClient = Liana_CEMImport_Model_Observer::getInstance()->getRestClient();

            if(! empty($orderList)) {
				$res = $restClient->call('import', $orderList);
				if ($res['succeed'] === true && ! empty($res['handle'])) {
					$model->updateLastRetrieved();
				} else {
					Mage::Log('magento-cemimport: orders import to CEM failed, retrying on next run');
				}
            }
        } catch( Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }

	public function exportCustomers(){
        $model = new Liana_CEMImport_Model_Customer();
        $customerList = $model->getCustomerList($this->cem_channel);
        try{
			$restClient = Liana_CEMImport_Model_Observer::getInstance()->getRestClient();

            if(! empty($customerList)){
				$res = $restClient->call('import', $customerList);
				if ($res['succeed'] === true && ! empty($res['handle'])) {
					$model->updateLastRetrieved();
				} else {
					Mage::Log('magento-cemimport: customers import to CEM failed, retrying on next run');
				}
            }
        } catch( Exception $ex){
            Mage::Log("magento-cemimport:".$ex->getMessages());
        }
    }
}
