<?php
class Liana_CEMImport_Model_Order extends Mage_Core_Model_Abstract {


    public function getOrderCollectionByID($order_ids = array()){
        $collection = $this->getOrderCollection();
        $collection->addAttributeToFilter('entity_id', array('in' => $order_ids));
        return $collection;
    }

    /**
    * Retrieve a collection of order from database through magento
    **/
    public function getOrderCollection(){
        //TO DO set time zone
        $cemimports = Mage::getModel('cemimport/cemimport')
                        ->getCollection()
                        ->setOrder('last_updated_at_time','DESC');

        $cemimport = $cemimports->getFirstItem();

        $collection = Mage::getModel('sales/order')
                            ->getCollection()
                            ->setOrder('updated_at','ASC');

        //Only export 1000 records per time
        $collection->setPageSize(1000);
        $collection->setCurPage(1);

        /**
        * If this is not the 1st run, last_updated_at_time 
        * will be saved to the table magento.cemimport
        */
        if(!is_null($cemimport)){
            $last_updated_at_time = $cemimport->getLastUpdatedAtTime();
            $collection->addFieldToFilter('updated_at', array('gt'=> $last_updated_at_time));

            $last_order_id = $cemimport->getLastOrderId();
        }

        $last_item = $collection->getLastItem();
        $last_updated_at_time = $last_item->getData('updated_at');

        if(!is_null($last_updated_at_time)){

            if($last_order_id!==$last_item->getId()){
                $new_cemimport = Mage::getModel('cemimport/cemimport');
                $new_cemimport->setLastUpdatedAtTime($last_updated_at_time);
                $new_cemimport->setImportType('order');
                $new_cemimport->setLastRetrievedId((int)$last_item->getId());
                $new_cemimport->save();
            }
        }

        return $collection;
    }
    
    /**
    *   Retrieve a order list from database and convert it into proper array structure
    */
    public function getOrderList(){
        $collection = $this->getOrderCollection();

        $data = array();

        if(!empty($collection) && (intval($collection->getSize())>0)){
            $channel_id = 'ecs';//ecs : ecommerce
           
            $data['channel'] = $channel_id;
            $orders = array();

            foreach($collection as $item){         
                $order = array();
                
                $order['identity'] = array('email'=> $item->getCustomerEmail());
                
                $billing_address = $item->getBillingAddress();

                $order['events'][] = array(
                    'verb' => 'contact',
                    'items' => array(
                        'first-name' => $item->getCustomerFirstname(),
                        'last-name'  => $item->getCustomerLastname(),
    			'street'     => $billing_address->getStreetFull(),
    			'zip'	     => $billing_address->getPostcode(),
    			'city'       => $billing_address->getCity()
                    )
                );
                
     			$order['events'][] = array(
                    'verb' => 'order',
                    'items' => array(
                        'id'  	            => $item->getIncrementId(),
    			'payment-method'    => $item->getPayment()->getMethodInstance()->getCode(),
    			'delivery-method'   => $item->getShippingDescription(),
    			'total-price'	    => $item->getSubtotal(),
                        'currency'          => $item->getOrderCurrencyCode(),
    			'status'            => $item->getStatus(),
                        'created'           => $item->getCreatedAt(),
                        'modified'          => $item->getUpdatedAt(),
                    )
                );

                $details = $this->getOrderDetails($item);

                $order['events'] = array_merge($order['events'], $details);

     			$orders[] = $order;
            }

            $data['data'] = $orders;
        }

        return $data;
     }

    /**
    * Convert the array structure of Order list into JSON
    */
    public function getOrderListJSON(){
        $data = $this->getOrderList();
        return json_encode($data);
    }

    /**
    * Get order details from an order
    */
    public function getOrderDetails($order){
        $order_rows = array();
        foreach($order->getItemsCollection() as $item)
        {
            $row                       = array();
            $row['verb'] 			   = 'orderrow';
            $row['items']['order-id']  = $order->getIncrementId();
            $row['items']['name']      = $item->getName();
            $row['items']['amount']    = $item->getQtyOrdered();
            $row['items']['price']     = $item->getPrice();
            $row['items']['total']     = $item->getRowTotalInclTax();
            $order_rows[] = $row;
        }
        return $order_rows;
    }
}
