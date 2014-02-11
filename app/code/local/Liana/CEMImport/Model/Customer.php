<?php

class Liana_CEMImport_Model_Customer extends Mage_Core_Model_Abstract {
    
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
                $new_cemimport = Mage::getModel('cemimport/cemimport');
                $new_cemimport->setLastCreatedAtTime($last_updated_at_time);
                $new_cemimport->setLastRetrievedId((int)$last_item->getId());
                $new_cemimport->setImportType('customer');
                $new_cemimport->save();
            }
        }

        return $collection;
    }

    public function getCustomerList(){
        $collection = $this->getCustomerCollection();

        $data = array();

        if(!empty($collection) && (intval($collection->getSize())>0)){
            //need to be changed, it should be retrieved from settings
            $channel_id = 'ecs';//ecs : ecommerce
            $data = array();
            $data['channel'] = $channel_id;

            $customers  = array();

            $model = Mage::getSingleton('customer/customer');

            foreach($collection as $item){
                $obj = $model->load($item->getId());
                $customer = array();
                $customer['identity'] = array('email'=> $model->getEmail());
                $customer['events'][] = array(
                    'verb' => 'customer',
                    'items' => array(
                        'id'         => $obj->getId(),
                        'first-name' => $obj->getFirstname(),
                        'last-name'  => $obj->getLastname(),
                        'email'      => $obj->getEmail()
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
