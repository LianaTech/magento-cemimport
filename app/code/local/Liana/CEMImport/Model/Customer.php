<?php

class Liana_CEMImport_Model_Customer extends Mage_Core_Model_Abstract {
	protected $last_updated_at_time = null; 
	protected $last_item_id = null;
	
	public function getCustomerCollection(){
        $cemimports = Mage::getModel('cemimport/cemimport')
                        ->getCollection()
                        ->addFieldToFilter('import_type','customer')
                        ->setOrder('last_updated_at_time','DESC');

		$cemimport = $cemimports->getFirstItem();

        $collection = Mage::getModel('customer/customer')
                            ->getCollection()
                            ->setOrder('updated_at','ASC');
		
		//Number of orders per page
		$collection->setPageSize(1000);
		$collection->setCurPage(1);

        /**
        * If this is not the 1st run, last_updated_at_time 
        * will be saved to the table magento.cemimport
        */
		if(!is_null($cemimport)){
            $last_updated_at_time = $cemimport->getLastUpdatedAtTime();
            $collection->addFieldToFilter('updated_at', array('gt'=> $last_updated_at_time));

            $last_customer_id = $cemimport->getLastRetrievedId();
        }

		$last_item = $collection->getLastItem();
		$last_updated_at_time = $last_item->getData('updated_at');

		if(!is_null($last_updated_at_time)){
			if($last_customer_id!==$last_item->getId()){
				$this->last_updated_at_time = $last_updated_at_time;
				$this->last_item_id = (int)$last_item->getId();
            }
        }

        return $collection;
	}

	public function updateLastRetrieved() {
		if (! isset($this->last_updated_at_time) || ! isset($this->last_item_id)) {
			return false;
		}
		$new_cemimport = Mage::getModel('cemimport/cemimport');
		$new_cemimport->setLastUpdatedAtTime($this->last_updated_at_time);
		$new_cemimport->setLastRetrievedId($this->last_item_id);
		$new_cemimport->setImportType('customer');
		$new_cemimport->save();

		return true;
	}

    public function getCustomerList($channel = null){
		$collection = $this->getCustomerCollection();
        $data = array();

        if(!empty($collection) && (intval($collection->getSize())>0)){
			$channel_id = empty($channel) ? 'ecs' : $channel;
            $data = array();
            $data['channel'] = $channel_id;

            $customers  = array();

            $model = Mage::getSingleton('customer/customer');
			
			foreach($collection as $item){
                $obj = $model->load($item->getId());
                $customer = array();
                $customer['identity'] = array('email'=> $model->getEmail());
                $customer['events'][] = array(
                    'verb' => 'contact',
                    'items' => array(
                        'id'         => $obj->getId(),
                        'first-name' => $obj->getFirstname(),
                        'last-name'  => $obj->getLastname(),
                        'email'      => $obj->getEmail(),
                    )
                );
                $customers[] = $customer;
            }
            $data['data'] = $customers;
        }
        return $data;
    }

	public function getCustomerListJSON(){
		$customers = $this->getCustomerList();
        return json_encode($customers);
    }
}
