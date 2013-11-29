<?php

class Liana_CEMImport_Model_Customer extends Mage_Core_Model_Abstract {
	
	public function getCustomerCollection(){
		$collection = Mage::getModel('customer/customer')->getCollection();
        return $collection;
	}

	public function getCustomerList(){
		$collection = $this->getCustomerCollection();
		//need to be changed, it should be retrieved from settings
        $channel_id = 1;
        $data = array();
        $data['channel'] = $channel_id;

        $customers 	= array();

        $model = Mage::getSingleton('customer/customer');

        foreach($collection as $item){
            $obj = $model->load($item->getId());
        	$customer = array();
        	$customer['identity'] = array('email'=> $model->getEmail());
            $customer['events'][] = array(
                'verb' => 'customer',
                'data' => array(
                    'customer-id'=> $obj->getId(),
                    'first-name' => $obj->getFirstname(),
                    'last-name'  => $obj->getLastname(),
                    'email'      => $obj->getEmail()
                )
            );
            $customers[] = $customer;
        }
        
        $data['data'] = $customers;
        return $data;
	}

	public function getCustomerListJSON(){
		$customers = $this->getCustomerList();
		return json_encode($customers);
	}
}
